<?php

//Section 1: Recieve & Set main Vairabls from Front
$examname = $_POST['examname'];
$answers = $_POST['answers'];
$questionIDs = $_POST['questionids'];
$username = $_POST['student'];
$qpoints = $_POST['qpoints'];
$i = 0;

foreach($questionIDs as $value){
  //Section 2: Send Question ID to back and recieve Response 
  $answer = $answers[$i];
  $url = "https://web.njit.edu/~sk2773/checkanswer.php";
  $ch = curl_init($url);
  $questionID = array('questionID' => $value);
  $postString = http_build_query($questionID, '', '&');
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);

  //Section 3: Go Through Backends data and parse for information I want
  $out = json_decode($result, true);
  $arr = $out[0];
  $functionName = $arr['functionname'];
  $numOfCases = $arr['testcasenum']; 
  $constr = $arr['const']; 
  $testcases = array($arr['testcases']) //I'm not sure if this will work or if i need to loop through it and add manually 
  
  //Section 4: Get Grades
  // 4.1 get the functionNameGrade and/or Replace FunctionName
  $funcNameGrade = funcNameCheck($answer, $functionname); 
  if ($funcNameGrade == -5){
    $answer = funcNameReplace($answer, $functionName); //I Need to test this new code
  }
  // 4.2 Check Test Cases 
  $testCaseGrades = testCaseCheck($testcases, $answer, $constr)
  
  //4.3 Constraint Checker - C0mplete
  $constrGrade = constrCheck($answer, $constr); 
  
  //4.4 Colon Check - Complete
  $colonGrade = colonCheck($answer); 
  
  //4.5 Get Total Grade
  $autograde = calculateGrade($qpoints, $funcNameGrade, $constrGrade, $testCaseGrades, $numofCases, $colonGrade);

//Section 5: All of the Functions
//5.1: Function for Checking if the FunctionName is correct
function funcNameCheck($answer, $functionname) { 
  $funcCheck = strpos($answer, $functionname);
  if ($funcCheck == false) {
    $funcNameGrade = -5; 
    return $funcNameGrade; 
  } else{
    $funcNameGrade = 0; 
    return $funcNameGrade; 
  }
}

//5.2: Function for checking if the constraint is contained within the answer
function constrCheck($answer, $constr) {
  if ($constr == 'none') {
    $constrGrade = 0;
    return $constrGrade;
  } else{
  $constrcheck = strpos($answer, $constr);
  if ($constrcheck == false){
    $constrGrade = -5;
    return $constrGrade;
  } else {
  $constrGrade - 0;
  return $constrGrade; 
  }
  }
}

//5.3: Function for checking that the end of the first line ends in a colon
function colonCheck($answer) {
  $firstLine = strstr($answer,"\n",true)
  $colonCheck = $firsLine[strlen($firstline)-1];
  if ($colonCheck == ''){
    $o = 1;
    while($colonCheck == ' ') {
      $colonCheck = $firsLine[strlen($firstline)-$o];
      $o+=1; 
      }
    if ($colonCheck == ':') {
      $colonGrade = 0;
      return $colonGrade;
      } else
      $colonGrade = -5; 
      return $colonGrade;
  } elseif ($colonCheck == ":") {
    $colonGrade = 0;
    return $colonGrade;
  } else {
  $colonGrade = -5;
  return $colonGrade;
  }
  }

//5.4: Function for Replacing the Bad Function Name
function funcNameReplace($answer, $functionName) {
  $lose = strstr($answer, "(");
  $badFunc = str_replace($lose, " ", $answer);
  $fn = strstr($badFunc, " "); 
  $answer = str_replace($fn, $functionName, $answer); 
  return $answer; 
} 

//5.5 Function for Testing the TestCases
function testCaseCheck($testcases, $answer, $constr) {
  $p = 0
  $testCaseGrades = array(); 
  while ($p <$numOfCases){
    $tc = $testcases[0]; 
    $tca = substr($tc, strpos($tc, ">") +2);
    $tcq = strtok($tc, '->');
    $p+=1; 
    if($constr == 'print'){
      $tester = $tcq;  
    } else{
      $tester = 'print(str('.$tcq.'))';
    }
    if ($answer[0] == ' ') {
      $newanswer = substr($answer, 1);
    }else {
    $newanswer = $answer; 
    }
    $newfile = $newanswer."\n".$tester;
    file_put_contents('qwert.py', $newfile);
    exec('python qwert.py', $out);
    if ($out[0] != $testcase2a){
      $testcasescore = -5;
      array_push($testCaseGrades, $testcasescore); 
      } else{
      $testcasescore = 0;
      array_push($testCaseGrades, $testcasescore); 
      }
  }
  return $testCaseGrades
} 

//5.6: Function for Calculating the Final Grade
function calculateGrade($qpoints, $funcNameGrade, $constrGrade, $testCaseGrades, $numofCases, $colonGrade) { 
  $totalGrade = $qpoints + $funcNameGrade + $constrGrade + $colonGrade;
  $a = 0;
  while ($a < $numOfCases) {
    $totalGrade += $testCaseGrades[$a]; 
    $a +=1;
  return $totalGrade; 
  }
  }


//Section 6. Send Results to the Back
  $url = "https://web.njit.edu/~sk2773/saveresult.php";
  $ch = curl_init($url);
  $qpoint = $qpoints[$i];
  if($autograde < 0){
      $autograde = 0;}
  $ag = array('testCaseGrades' => $testCaseGrades, 'student' => $username, 'functionnamescore' => $funcNameGrade, 'constrGrade' => $constrGrade, 'colonGrade' => $colonGrade, 'numOfCases' => $numOfCases, 'answer' => $answer, 'qpoints' => $qpoint, 'exam' => $examname, 'questionid' => $questionIDs[$i], 'autograde' => $autograde,  );
    $postString = http_build_query($ag, '', '&');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    
//Section 7. Start the Loop Again
  i+=1; 
?>
