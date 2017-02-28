<?php 
/*
*   news-feed.php - page for viewing all the news retireved based on a user's choice of category. 
*	@author S. Allen
*
*/
include 'cache.php';

?>

<html>
<head>
	<title>News Feed</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>

<?php

//if get request contains a valid category id, get it. Else display error message.
if(isset($_GET['id']) && (int)$_GET['id'] > 0) {
	 $categoryId = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
	 
	echo '<h1>News Feed: '.$categories[$categoryId].'</h1>';
	checkFeed($categoryId); //make sure that the feed is available. 
	displayFeed($categoryId); //display the feed. 

}else{
	echo '<p>Sorry, could not retrieve any news items for that category at this time.</p>';
}

function checkFeed($id){
	if (!isset($_SESSION['newsStories'][$categoryId]))
	{
		$result = getFeed($id);
		if (!$result) 
		{
			echo '<p>Could not retrieve feed at this time</p>';
			return;
		}
	}
}

function displayFeed($id) {
	// Print the feedReadTime
	echo 'Last updated at ';
	echo date('H:i', $_SESSION['feedReadTime']);
	echo ' - ';
	echo '<a href=destroy_session.php?id='.$_GET['id'].'>Reload XML data</a>';
	echo '<br>';
	echo '<br>';

	// Print out article titles with links.
	$j = 0;

	$stories = $_SESSION['newsStories'][$id];

	
	foreach ($stories as $item) {
		echo '<div class="story">';
	    echo '<h3><a href=' . $item['link'] . '>';
	    echo $item['title'] . '</a></h3>';
	    //echo '<br>';
	    $j++;
	}
}

?>

</body>
</html>