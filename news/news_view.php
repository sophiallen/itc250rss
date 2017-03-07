<?php
/**
 * @package News
 * desc: Sub list page
 * @author J Gilmer
 * @3.4.17
 * @see index.php in "news" directory
 *
 * Sub category list page for an RSS news feed project Seattle Central * ITC 250
 *
 * @license PHP License, version 3.01
 * @see config_inc.php  
 * @see header_inc.php
 * @see footer_inc.php 
 * @todo none
 */
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
//spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index survey pages

if((isset($_GET['id']) && (int)$_GET['id'] > 0)){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}
else{
	myRedirect(VIRTUAL_PATH . "news/index.php");
}

//SQL to pull from FeedsCategories and Feeds tables

$sql = "select c.CategoryName, c.Description, f.FeedName, f.FeedID
        from Categories c left join Feeds f
        on c.CategoryID = f.CategoryID 
        where c.CategoryID = " . $myID . "
        order by f.FeedID asc";

$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));


# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page

if(mysqli_num_rows($result) > 0){
    $config->titleTag = "'" . $result->fetch_field_direct(2)->name . "' Feed!";

#END CONFIG AREA ---------------------------------------------------------- 
get_header(); #defaults to theme header or header_inc.php
    
echo '<h2 align="center">News Categories</h2>';

foreach($result as $row){#objects of class row from SQL rows
    //$row = new stdClass;
    $CategoryName = $row['CategoryName'];
    $FeedID = $row['FeedID'];
    $FeedName = $row['FeedName'];
    $currentRow = new Row($FeedID, $FeedName, $CategoryName);
    $config->rows[]=$currentRow;

}

 echo '<table class="table table-striped">';
    echo '<tr>';
        echo '<th><a href="' . VIRTUAL_PATH . 'news/index.php' . '">Categories</a> &nbsp; >> &nbsp; ' . $CategoryName . '</th></tr>';
    #two for each loops to separate $CategoryName
    

     
foreach($config->rows as $row)
{#loop through each object
    echo '<tr>';
        echo '<td><a href="news-feed.php?id=' . $row->FeedID . '">' . $row->FeedName . '</a></td></tr>';
        }
    echo '</table>';




get_footer(); #defaults to theme footer or footer_inc.php
}#end if block $result>0
else{//no subcategory!
    header('Location: ' . VIRTUAL_PATH . 'news/index.php');
}

class Row
{
    public $FeedID = 0;
    public $FeedName = '';
    public $CategoryName = '';

        public function __construct($FeedID, $FeedName, $CategoryName){
            $this->FeedID = $FeedID;
            $this->FeedName = $FeedName;
            $this->CategoryName = $CategoryName;
            
        }

}


