<?php
//Section 1: Receive Info From Front
  $exam = $_POST['exam']; 
  $teachergrade = $_POST['teachergrade'];
  $functionnamec = $_POST['functionnamec'];
  $comment = $_POST['comment'];
  $questionid = $_POST['questionid'];
  $student = $_POST['student'];
  $reply = '1';
  $testCaseNums = $_POST['testcaseNum']; 
  $testcases1 = $_POST['testcase1'];
  $testcases2 = $_POST['testcases2']; 
  $testcases3 = $_POST['testcases3'];
  $testcases4 = $_POST['testcases4'];
  
//Section 2: Set Counters
  $i = 0; 
  $tc1 = 0;
  $tc2 = 0;
  $tc3 = 0; 
  $tc4 = 0; 

//Section 3: Loop through each of the recieved questions to send individuall to back
  foreach ($questionid as $qid) {
    $url = "https://web.njit.edu/~sk2773/teachergrade.php";
    $testCaseNum = $testCaseNums[$i];
    
    //Section 3.1: Determine which testcases to send with question
    if ($testCaseNum == 2) {
     $test1c = $testcases1[$tc1]; 
     $test2c = $testcases1[$tc2]; 
     $test3c = 0; 
     $test4c = 0; 
     $tc1 +=1; 
     $tc2 +=1; 
     } elseif ($testcaseNum ==3) {
       $test1c = $testcases1[$tc1]; 
       $test2c = $testcases2[$tc2]; 
       $test3c = $testcases3[$tc3]; 
       $test4c = 0; 
       $tc1 +=1; 
       $tc2 +=1;
       $tc3 +=3; 
    } else {
      $test1c = $testcases1[$tc1]; 
      $test2c = $testcases2[$tc2]; 
      $test3c = $testcases3[$tc3]; 
      $test4c = $testcases4[$tc4]; 
      $tc1 +=1; 
      $tc2 +=1;
      $tc3 +=1; 
      $tc4 +=1; 
    }
    //Secton 3.2:  Send $updatedGrades to back
    $ch = curl_init($url);
    $updatedGrades = array('exam' => $exam, 'student' => $student, 'questionid' => $questionid[$i], 'comment' => $comment[$i], 'teachergrade' => $teachergrade[$i], 'functionnamec' => $functionnamec[$i], 'test1c' => $test1c, 'test2c' => $test2c, 'test3c' => $test3c, 'test4c' => $test4c,'testcasenum' =>  $testcasenum );
    $postString = http_build_query($updatedGrades, '', '&');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $i = $i + 1;
    $result = curl_exec($ch);
    curl_close($ch);
    $value = json_decode($result, true);
    if($value['response'] != "200"){
            $reply = '0';
    }
  }
  header('Content-Type: application/json');
  echo json_encode(array('response'=>$reply));


?>
