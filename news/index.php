<?php
/**
 * @package News
 * desc: List page
 * @author J Gilmer
 * @3.4.17
 * @see news_view.php in "news" directory
 *
 * Inde page of Database to RSS project for Seattle Central ITC 250
 *
 * @license PHP License, version 3.01
 * @see config_inc.php  
 * @see header_inc.php
 * @see footer_inc.php 
 * @todo none
 */
# '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

$config->titleTag = "Read Simple News"; #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 


# SQL statement - PREFIX is optional way to distinguish your app
$sql = "select CategoryID, CategoryName, Description
        from Categories
        order by CategoryID asc";

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<h2 align="center">Read Simple: RSS News</h2>

<!--<p>creates a singleton (shared) mysqli connection via a class named IDB</p>-->
<?php
#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

//echo '<div align="center"><h4>SQL STATEMENT: <font color="red">' . $sql . '</font></h4></div>';
if(mysqli_num_rows($result) > 0)
{#there are records - present data
     echo '<table class="table table-striped">';
    echo '<tr>';
        echo '<th>' . $result->fetch_field_direct(1)->name . '</th>';
        echo '<th>' . $result->fetch_field_direct(2)->name . '</th>';
        echo '</tr>';
	while($row = mysqli_fetch_assoc($result))
	{# pull data from associative array
	   
        echo '<tr>';
        echo '<td><a href="news_view.php?id=' . $row['CategoryID'] . '">' . $row['CategoryName'] . '</a></td>';
       // echo '<td>' . $row['CategoryName'] . '</td>';
	   if(!empty($row['Description'])){
	   echo '<td>' . $row['Description'] . '</td>';}
        else {echo '<td>Nothing here</td>';}
	}
    echo '</table>';
}else{#no records
	echo '<div align="center">Sorry, there are no records that match this query</div>';
}
@mysqli_free_result($result);
get_footer(); #defaults to footer_inc.php
?>