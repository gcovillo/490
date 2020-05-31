<?php
// receive request from front 
$teacherGradeRequest = $_POST['teachergradeRequest'];


//pass the request to the back
$url = "https://web.njit.edu/~sk2773/teachergrade.php"; 

$ch = curl_init($url);

$tgr = array('teacherGradeRequest' => $teacherGradeRequest);
$postString = http_build_query($tgr, '', '&');

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//get the auto-graded results from db 
$result = curl_exec($ch);
curl_close($ch);

//  echo the results to front 
echo $result

//  receive new comments and grades from front

$newGrade = $_POST['newGrade'];
$comment = $_POST['comment'];
$QID = $_POST['QID'];


// post comments and new grades back to db
$url = "https://web.njit.edu/~sk2773/?????";  //fix this

$ch = curl_init($url);



$updatedGrades = array('newGrade' => $newGrade, 'comment' => $comment, 'QID' => $QID);
$postString = http_build_query($updatedGrades, '', '&');


curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
curl_close($ch);

?>
