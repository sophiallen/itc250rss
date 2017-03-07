<?php 
/*
*   News-feed.php - page for viewing all the news retireved based on a user's choice of category. 
*	@author S. Allen
*
*/
include '../includes/cache.php';
require '../inc_0700/config_inc.php'; 

get_header();

//if get request contains a valid category id, get it. Else display error message.
if(isset($_GET['id']) && (int)$_GET['id'] > 0) {
	$categoryId = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
	 
    //Fake categories, to be replaced with SQL call to get category names later:  
    // $categories = ['Puppies', 'Kittens', 'Brown paper packages tied up with string'];


    $sql = 'Select FeedName from Feeds where FeedID = '.$categoryId;
	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
	if(mysqli_num_rows($result) > 0){
		$feedName;
		foreach ($result as $row){
			$feedName = $row['FeedName'];
		}
			
			echo '<h1>News Feed: '.$feedName.'</h1>';
			checkFeed($categoryId, $feedName); //make sure that the feed is available. 
			displayFeed($categoryId); //display the feed. 			
			
		// echo var_dump($result);
	}

	// echo '<h1>News Feed: '.$categories[$categoryId].'</h1>';
	// checkFeed($categoryId); //make sure that the feed is available. 
	// displayFeed($categoryId); //display the feed. 

}else{
	echo '<p>Sorry, could not retrieve any news items for that category at this time.</p>';
}

function displayFeed($id) {
	// Print the feedReadTime
	echo 'Last updated at ';
	echo date('H:i', $_SESSION['feedReadTimes'][$id]);
	echo ' - ';
	echo '<a href=../includes/destroy_session.php?id='.$_GET['id'].'>Reload XML data</a>';
	echo '<br>';
	echo '<br>';

	$stories = $_SESSION['newsStories'][$id];

	// Print out article titles with links.
	foreach ($stories as $item) {
		echo '<div class="story">';
	    echo '<h4><a href=' . $item['link'] . '>';	 
	    echo $item['title'] . '</a></h4>';
	}
}


get_footer();
?>


