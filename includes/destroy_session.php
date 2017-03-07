<?php
/**
*   destroy_session.php destroys the current session and restarts a new one.
*	@author Ian Follett <ianfollett@gmail.com>
*
*/

// Resume the existing session.
session_start();

// Destroy it.
session_destroy();

// Load the cache.php
header('location:../news/news-feed.php?id='.$_GET['id']);

exit();