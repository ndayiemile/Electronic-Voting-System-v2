
<?php
/*connecting to the database */
$db=mysqli_connect('localhost','root','','evs');
if(mysqli_connect_error()){
    echo "there was an error in connecting to the data base";
    echo "PLEASE TRY AGAIN LATER!";
}
//initialisation to the variables
$errors=array();
/*response after page1 submission */
if(isset($_POST['regist'])){
    $record=$_SESSION['record'];
    $num_voters=$_SESSION['voters'];
    $counts=$_POST['num_candidates'];
for($i=1;$i<$counts;$i++){ 
  //initialization to the form 1 inputs
    $cd_name=$_POST["cd_name$i"];
    $cd_age=$_POST["cd_age$i"];
    $cd_position=$_POST["cd_position$i"];
    $cd_id=$_POST["cd_id$i"];
    $cd_gender=$_POST["cd_gender$i"];
    $cd_email=$_POST["cd_email$i"];
    $cd_comment=$_POST["cd_comment$i"];
    $n_candidates=$counts-1;//number of candidates

//form validation for main inputs
    if(empty($cd_name)){array_push($errors,"candidate ".$i." name NAME missing");}
    if(empty($cd_age)){array_push($errors,"candidate ".$i." name AGE missing");}
    if(empty($cd_position)){array_push($errors,"candidate ".$i." POSITION is missing");}
    if(empty($cd_id)){array_push($errors,"candidate ".$i." ID is missing");}
    if(empty($cd_gender)){array_push($errors,"candidate ".$i." GENDER is missing");}
    if(empty($cd_email)){array_push($errors,"candidate ".$i." EMAIL is missing");}
//check in the database
    $cnd_check_query = "SELECT * FROM $record WHERE cd_name='$cd_name' OR cd_email='$cd_email' LIMIT 1";
    $cndresult = mysqli_query($db, $cnd_check_query);
    $cnd = mysqli_fetch_assoc($cndresult);
    
    if ($cnd) { // if user exists
      if ($cnd['cd_name'] === $cd_name) {
        array_push($errors, "the candidate $i name already exists");
      }
  
      if ($cnd['cd_email'] === $cd_email) {
        array_push($errors, "the candidate $i email already exists");
      }
    }
   //recording data into the database if no errors found
   if(count($errors)==0){ 
    $session_initial_state="paused";
    $register_cd="INSERT INTO $record (cd_name,cd_age,cd_position,cd_id,cd_gender,cd_email,cd_comment,n_candidates,n_voters,session_state) VALUES('$cd_name','$cd_age','$cd_position','$cd_id','$cd_gender','$cd_email','$cd_comment','$n_candidates','$num_voters','$session_initial_state')";
    mysqli_query($db,$register_cd);
   }
}
//redirector to the dashboard page
if(count($errors)==0){
    $_SESSION['holder']=$record;
    header("location:admins_dash.php");
}
}
?>