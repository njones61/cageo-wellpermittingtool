<?php
// Try to disable caching
header("Content-Type: image/jpg");
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

$folder = "http://10.2.115.186/WellPermitting/N%20Utah%20Co%204/";

//echo file_get_contents( $folder . htmlspecialchars($_REQUEST["file"]) );
echo file_get_contents( $folder . $_REQUEST["file"] );
?>
