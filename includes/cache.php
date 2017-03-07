<?php

/**
 * cache.php creates or continues a session and provides a getFeed function to download and extract the data from
 * a requested news feed from Google News or provide a cache version if the feed has already been requested in the last
 * ten minutes.
 * 
 * @author Ian Follett and Sophia Allen 
 */


// Start or continue a session.
session_start();

//Function to trigger reload of feed if no feed has been cached, or the feed has timed out. 
function checkFeed($id, $categoryName){

    $set = isset($_SESSION['newsStories'][$id]);
     //$timeout = time() - $_SESSION['feedReadTimes'][$id] > 600;

    //if no feed set in cache, or 10 mins expired:
	if (!$set || (time() - $_SESSION['feedReadTimes'][$id] > 600))
	{
        //try to reload the feed.
		$result = getFeed($id, $categoryName);

        //if unable to get the feed, display an error message. 
		if (!$result) 
		{
			echo '<p>Could not retrieve feed at this time</p>';
			return;
		}
	}
}

//Sends a request for RSS and saves it to the session, based on a category id. 
function getFeed($categoryId, $categoryName){

    //turn name into url-safe string: 
    $categoryName = urlencode($categoryName);

    //create string
    $queryString = 'https://news.google.com/news/feeds?pz=1&cf=all&ned=en&hl=us&q='.$categoryName.'&output=rss';

    // Interpret the XML feed to an object.
    $xml = simplexml_load_file($queryString);

    // Create an array to store in the session since I don't think you can store an object.
    $_SESSION['newsStories'][$categoryId] = array();
    
    // Set the time the XML feed was read.
    $_SESSION['feedReadTimes'][$categoryId]= time();

    // Convert the object into a regular array and store it in the session. (Some code lifted from:
    // https://github.com/nuhil/google-news-parser-json/blob/master/GoogleNews.php)
    $i = 0;

    foreach ($xml->channel->item as $item) {

        preg_match('@src="([^"]+)"@', $item->description, $match);
        $parts = explode('<font size="-1">', $item->description);


        $_SESSION['newsStories'][$categoryId][$i]['title'] = (string)$item->title;
        $_SESSION['newsStories'][$categoryId][$i]['image'] = sizeof($match) >=2 ? $match[0] : '';
        $_SESSION['newsStories'][$categoryId][$i]['link'] = (string)$item->link;
        $_SESSION['newsStories'][$categoryId][$i]['summary'] = strip_tags($parts[2]);
        $i++;
    }

    //return success response. 
    return true;
}

