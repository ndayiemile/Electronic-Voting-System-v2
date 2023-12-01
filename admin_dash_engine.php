<?php 
$db=mysqli_connect('localhost','root','','evs');
if(mysqli_connect_error()){
    echo "there was an error on connecting to the database";
    echo "please try ahain later";
}
$place=$_SESSION['email'];
 //check for voting_ids availabity
 $vote_check2="SELECT*FROM  $place WHERE n_voters=0";
 $vote_checking2=mysqli_query($db,$vote_check2);

//saviing the created ids
if(isset($_POST['manual_ids_save'])){
    $voters=$_SESSION['number_voters'];
    $cand=$_SESSION['cand'];
    for($i=1;$i<=$voters;$i++){
        $voting_id=$_POST["manual_input$i"];
        $insert="INSERT INTO $place(voters_id) VALUE ('$voting_id')";
        mysqli_query($db,$insert);

    }
 }
 //saving the edited ids
 if(isset($_POST['manual_ids_edit'])){
    $total=$_SESSION['total'];
    $cand=$_SESSION['cand'];
    for($i=1+$cand;$i<=$total;$i++){
        $voting_id=$_POST["manual_input$i"];
        $insert="UPDATE $place SET voters_id='$voting_id' WHERE id=$i LIMIT 1";
        mysqli_query($db,$insert);

    }
 }
 //session management//START
 if((isset($_POST['session_manager1'])) && ((mysqli_num_rows($vote_checking2))!=0)){
    $insert="UPDATE $place SET session_state='started' WHERE id=1 LIMIT 1";
    mysqli_query($db,$insert);

 }
 //session management//STOP
 if(isset($_POST['session_manager2'])){
    $insert="UPDATE $place SET session_state='paused' WHERE id=1 LIMIT 1";
    mysqli_query($db,$insert);

 }

?>