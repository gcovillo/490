<?php 
//receive examName, answers, and Question IDS from front
$examName = $_POST('examName'); //need to get exam name so I can get the testcases from back
$answers = $_POST('answers');
$QIDS = $_POST('qids');

//need to get testcases from back
//need to get func name from back
$examLength = (int)$_POST['examLength'];

for ($x = 0; $x <= $examLength; $x++) {
  $answer = $answers[$x];
  $funcCheck = strpos($answer, $funcname);
  if ($funcCheck !== FALSE) { //means they put the correct function name
    $var_str = var_export($answer, true);
    file_put_contents('qwerty.py', $var_str); //NEED TO APPEND FUNCTION CALL AT END
    $command = escapeshellcmd(python3 "qwert.py");
    $output = shell_exec($command);
    } else {
    //subtract 5 points
    //replace function name
    $lose = strstr($answer, ":");
    $badFunc = str_replace($lose, " ", $answer);
    $goodFunc = "def"." ".$funcName; //need to find a way to incorportate function name for forrect question into here
    $py = $goodFunc.$lose;
    $var_str = var_export($py, true);
    file_put_contents('qwerty.py', $var_str);
    $command = escapeshellcmd(python3, "qwerty.py");
    $output = shell_exec($command);
    }
    
    
  }
}
//send results to back
?> 
