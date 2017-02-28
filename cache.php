<?php

// Start or continue a session.
session_start();

// Check to see if feedReadTime is not set or if it's been more than 600 seconds since it was last set.
if(!isset($_SESSION['feedReadTime']) || time() - $_SESSION['feedReadTime'] > 600) {

    //set, or re-set the session's news feed data to an empty array.
    $_SESSION['newsStories'] = array();

}


function getFeed($categoryId){

    //Fake categories, to be replaced with SQL call to get category names later:  
    $categories = ['Puppies', 'Kittens', 'Brown paper packages tied up with string'];

    //fake checking to see if id is in our db
    if ($categoryId > sizeof($categories)){
        //return false if the category doesn't exist.
        return false;
    }


    //get its name, and turn it into url-safe string: 
    $categoryName = urlencode($categories[$categoryId]);

    //create string
    $queryString = 'https://news.google.com/news/feeds?pz=1&cf=all&ned=en&hl=us&q='.$categoryName.'&output=rss';

    // Interpret the XML feed to an object.
    $xml = simplexml_load_file($queryString);

    // Set the time the XML feed was read.
    $_SESSION['feedReadTime'] = time();

    // Create an array to store in the session since I don't think you can store an object.
    $_SESSION['newsStories'][$categoryId] = array();

    // Convert the object into a regular array and store it in the session. (Some code lifted from:
    // https://github.com/nuhil/google-news-parser-json/blob/master/GoogleNews.php)
    $i = 0;

    foreach ($xml->channel->item as $item) {

        preg_match('@src="([^"]+)"@', $item->description, $match);
        $parts = explode('<font size="-1">', $item->description);

        $_SESSION['newsStories'][$categoryId][$i]['title'] = (string)$item->title;
        $_SESSION['newsStories'][$categoryId][$i]['link'] = (string)$item->link;

        $i++;
    }

    //return success response. 
    return true;
}
