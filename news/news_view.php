<?php
/**
 * survey_view.php is a page to demonstrate the proof of concept of the 
 * initial SurveySez objects.
 *
 * Objects in this version are the Survey, Question & Answer objects
 * 
 * @package SurveySez
 * @author William Newman
 * @version 2.12 2015/06/04
 * @link http://newmanix.com/ 
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see Question.php
 * @see Answer.php
 * @see Response.php
 * @see Choice.php
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

$sql = "select c.CategoryName, c.Description, f.FeedName,             f.FeedID
        from wn17_FeedsCategories c left join wn17_Feeds f
        on c.CategoryID = f.CategoryID 
        where c.CategoryID = " . $myID . "
        order by f.FeedID asc";

$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));



# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page

if(mysqli_num_rows($result) > 0){
    $config->titleTag = "'" . $result->fetch_field_direct(2)->name . "' Feed!";


/*$mySurvey = new SurveySez\Survey($myID); //MY_Survey extends survey class so methods can be added
if($mySurvey->isValid)
{
	$config->titleTag = "'" . $mySurvey->Title . "' Feed!";
}else{
	$config->titleTag = smartTitle(); //use constant 
}*/
#END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
    
    
//$obj = mysqli_fetch_object($result);
//$fieldinfo=mysqli_fetch_field_direct($result,0);
//mysqli_store_result (mysqli_query(IDB::conn(),$sql));
//echo '<h3>' . $obj->CategoryName . '</h3>';
     

     echo '<table class="table table-striped">';
    echo '<tr>';
        echo '<th>' . $result->fetch_field_direct(2)->name . '</th>';
        echo '</tr>';
    //    mysqli_use_result(mysqli_query(IDB::conn(),$sql));
         while($row = mysqli_fetch_assoc($result))
	{# pull data from associative array
    
    echo '<tr>';
        echo '<td>' . $row['CategoryName'] . ' -> <a href="placeholder.php?id=' . $row['FeedID'] . '">' . $row['FeedName'] . '</a></td></tr>';
        }
    echo '</table>';


/*
<?php

if($mySurvey->isValid)
{ #check to see if we have a valid SurveyID
	echo '<p>' . $mySurvey->Description . '</p>';
	echo $mySurvey->showQuestions();
}else{//no such survey!
    //echo '<div align="center">What! No such survey? There must be a mistake!!</div>';
    header('Location: ' . VIRTUAL_PATH . 'surveys/index.php');
}
*/
get_footer(); #defaults to theme footer or footer_inc.php
}



