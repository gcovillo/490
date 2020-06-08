<?php
$getexam = $_POST['getexam'];
$url = "https://web.njit.edu/~sk2773/query.php"; 

$ch = curl_init($url);

$query = array('query' => $getexam);
$postString = http_build_query($query, '', '&');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//get the auto-graded results from db 
$result = curl_exec($ch);
curl_close($ch);

//  echo the results to front 
echo $result;

?>
