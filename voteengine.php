<?php
$db=mysqli_connect('localhost','root','','evs');
if(mysqli_connect_error()){
 echo "there was an error on conneecting to the database";
 echo "please try again later";
 exit();
}
$errors=array();
if(isset($_POST['vote'])){
    $book=$_SESSION['book'];
    //get the vote from voting page
    $voter_id=$_POST['voter_id'];
    $candidate_id=$_POST['candidate_id']; 
    //session state based validation
    $validator3="SELECT session_state FROM $book WHERE id=1 LIMIT 1";
    $validator_in3=mysqli_query($db,$validator3);
    $valid3=mysqli_fetch_assoc($validator_in3);
    $validating3=$valid3['session_state'];
    $state="started";
    if($validating3==$state){ 
    //vote form validation
        if(empty($voter_id)){array_push($errors,"your voter ID is missing");}
        if(empty($candidate_id)){array_push($errors,"your choice CANDIDATE ID is missing");}
        $validator="SELECT cd_id FROM $book WHERE cd_id='$candidate_id'";
        $validator_in=mysqli_query($db,$validator);
        $valid=mysqli_fetch_assoc($validator_in);
        $validating=$valid['cd_id'];
        if((empty($validating)) || ($validating!==$candidate_id)){array_push($errors,"the CANDIDATE ID is invalid");}
        $validator2="SELECT voters_id FROM $book WHERE voters_id='$voter_id'";
        $validator_in2=mysqli_query($db,$validator2);
        $valid2=mysqli_fetch_assoc($validator_in2);
        $validating2=$valid2['voters_id'];
        if((empty($validating2)) || ($validating2!==$voter_id)){array_push($errors,"the YOUR VOTE ID is invalid");}
    }
    else {
        array_push($errors,"THE ELECTION IS NOT YET STARTED");
    }
   
    
    //voting if no error found
    if(count($errors)==0){  
    //fetch already voted ids vote from db
    $voted_id="SELECT vote_checker FROM $book WHERE voters_id='$voter_id'";
    $voted_id_in=mysqli_query($db,$voted_id);
    $voted_id_out=mysqli_fetch_assoc($voted_id_in);
    $votedid=$voted_id_out['vote_checker'];
        if(empty($votedid)){  
            //get pre-existing votes from the database
            $point="SELECT votes FROM $book WHERE cd_id='$candidate_id'";
            $query=mysqli_query($db,$point);
            $votes=mysqli_fetch_assoc($query);
            $voices=$votes['votes'];
            //add the new vote and update the database
            $voices=$voices+1;
            $update="UPDATE $book SET votes=$voices  WHERE cd_id='$candidate_id'";
            mysqli_query($db,$update);
            //assine the vote to the used id
            $update2="UPDATE $book SET vote_checker='VOTED'  WHERE voters_id='$voter_id'";
            mysqli_query($db,$update2);
            
            //redirecting to success page
            header("location:success.php");
        }
        else{
            array_push($errors,"VOTER ID already used");
        }
    }
}
?>