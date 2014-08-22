<?php

//
// 
//
//
// 
//
//-------------------------------------------------------------------------------

// Try to disable caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

$url = "http://10.2.115.186/WellPermitting/N%20Utah%20Co%204/Output/messages.txt";

echo file_get_contents($url);


?>
