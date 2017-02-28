<?php

// Resume the existing session.
session_start();

// Destroy it.
session_destroy();

// Load the cache.php
header('location:news-feed.php?id='.$_GET['id']);

exit();