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

$url = "http://10.2.115.186/WellPermitting/N%20Utah%20Co%204/runTool.php";

//echo file_get_contents($url);
//echo $url;

// The POST URL and parameters
$request = $url;    
$postargs = 'applicationID='. htmlspecialchars($_GET["applicationID"]) .'&contourInterval='. htmlspecialchars($_GET["contourInterval"]) ;
$postargs = $postargs . '&OutputWells='. htmlspecialchars($_GET["OutputWells"]);
$postargs = $postargs . '&OutputDrawdown='. htmlspecialchars($_GET["OutputDrawdown"]) ;
$postargs = $postargs . '&OutputDrainPoints='. htmlspecialchars($_GET["OutputDrainPoints"]) ;
$postargs = $postargs . '&OutputDrainAreas='. htmlspecialchars($_GET["OutputDrainAreas"]) ;
$postargs = $postargs . '&OutputPDF='. htmlspecialchars($_GET["OutputReport"]) ;


// Get the curl session object
$session = curl_init($request);

// Set the POST options.
curl_setopt ($session, CURLOPT_POST, true);
curl_setopt ($session, CURLOPT_POSTFIELDS, $postargs);
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);


// Do the POST and then close the session
$response = curl_exec($session);
curl_close($session);

echo $response;


?>
