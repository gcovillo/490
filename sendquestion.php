<?php
// receive data from front end
$topic = $_POST['topic'];
$difficulty = $_POST['difficulty'];
$question = $_POST['question'];
$funcName = $_POST['funcname'];
$tc1Q = $_POST['tc1Q'];
$tc1A = $_POST['tc1A'];
$tc2Q = $_POST['tc2Q'];
$tc2A = $_POST['tc2A'];


//pacakage data and send to backend
$url = "https://web.njit.edu/~sk2773/getquestions.php"; 


$ch = curl_init($url);

//open connection

$q = array('topic' => $topic,'difficulty' => $difficulty, 'question' => $question, 'funcName' => $funcName, 'tc1Q' => $tc1Q, 'tc1A' => $tc1A, 'tc2Q' => $tc2Q, 'tc2A' => $tc2A);
$postString = http_build_query($q, '', '&');

//set options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

?>
