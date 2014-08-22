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



$wellId = htmlspecialchars($_GET["Well_ID"]);
$query = "DELETE FROM " . $wellTable . " WHERE Well_ID=" . $wellId;
$result = mysql_query($query);


if (!$result) 
{
  die('Invalid query: ' . mysql_error());
}

//echo $query;
echo $result;

?>
