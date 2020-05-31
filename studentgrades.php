<?php
$user = $_POST['user'];

//receive data from backend
$url = "https://web.njit.edu/~sk2773/studentgrades.php"; 
$ch = curl_init($url);

$userRequest = array('user' => $user);
$postString = http_build_query($userRequest, '', '&');


curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

echo $result
?>
