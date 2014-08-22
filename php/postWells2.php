<?php

//
// 
//
//
// 
//
//-------------------------------------------------------------------------------


// stores $username, $password, $database, $server, and $wellTable
require('dbinfo.php');



// Opens a connection to a MySQL server.
$connection = mysql_connect ($server, $username, $password);

if (!$connection) 
{
  die('Not connected : ' . mysql_error());
}


// LatSets the active MySQL database.
$db_selected = mysql_select_db($database, $connection);

if (!$db_selected) 
{
  die('Can\'t use db : ' . mysql_error());
}


$wellTableRowNames = array("Latitude","Longitude","Flow_cfd","ScreenTopElev_ft","ScreenBotmElev_ft","ApplicationID");


$fieldValueList = array();
foreach ($wellTableRowNames as $rowName) {

  $val = htmlspecialchars($_GET[$rowName]);  // change to post
  if ( strlen( $val ) > 0 ) {
    $fieldValueList[] = $val;
  }
  else{
    $fieldValueList[] = 'null';
  }

}


$query = "INSERT INTO " . $wellTable . "(" . implode( ',' , $wellTableRowNames ) . ") VALUES (" . implode( ',' , $fieldValueList ) . ")";
$result = mysql_query($query);


if (!$result) 
{
  die('Invalid query: ' . mysql_error());
}

echo $query;

?>
