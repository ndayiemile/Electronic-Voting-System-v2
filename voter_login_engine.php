<?php
session_start();
$errors=array();
$org_comm_name="";
$email="";
$db=mysqli_connect('localhost','root','','evs');
if(mysqli_connect_error()){
    echo "there was an error on connecting to the database";
    echo "please try ahain later";
}
//login  the voter
if(isset($_POST['login_voter'])){  
    $email=$_POST['email'];
    $org_comm_name=$_POST['org_comm_name'];
    //form validation for errors
    if((empty($email)) && (empty($org_comm_name))){array_push($errors,"*atleast one is neeeded");}
    if (count($errors) == 0) {
         //check if the email or comm name exists
        $query = "SELECT * FROM admins WHERE email='$email' OR org_comm_name='$org_comm_name'";
        $results = mysqli_query($db, $query);
         //login the user if no error
        if (mysqli_num_rows($results) == 1) {  
            //fetch the email if the community name is the one entered
                if(empty($email)){ 
                    $f_email="SELECT email FROM admins WHERE org_comm_name='$org_comm_name' LIMIT 1";
                    $fe_email=mysqli_query($db,$f_email);
                    $fetch_email=mysqli_fetch_assoc($fe_email);
                    $real_email=$fetch_email['email'];
                    $_SESSION['email']=md5($real_email);
                    header('location:voting.php');
                }
                elseif(empty($org_comm_name)){
                    $f_email="SELECT email FROM admins WHERE email='$email' LIMIT 1";
                    $fe_email=mysqli_query($db,$f_email);
                    $fetch_email=mysqli_fetch_assoc($fe_email);
                    $real_email=$fetch_email['email'];
                    if($email===$real_email){ 
                        $_SESSION['email']=md5($email);
                        header('location:voting.php');
                    }
                    else{
                        array_push($errors,"wrong email");
                    }

                }
                else{
                    $_SESSION['email']=md5($email);
                    header('location:voting.php');
                }
            }
        else {
          array_push($errors, "wrong email/org_com name");
        }
    }
}
?>