<?php include('reg_candidate.php');
session_start();
$account=$_SESSION['email'];
$_SESSION['book']=$account;
?>
<?php include('voteengine.php');?>
<html>
<head>
<title>VOTING TWO</title>
<style>

.input_group{
height: 40px;
color:rgb(41, 39, 39);
font-size: 15px;
width: 80%;
}
.input_div{
padding: 10px;
}
.subdiv{
    background-color:rgb(35,35,20);;
    margin:10px 0px 0px 30px;
    padding: 30px;
    width:47%;
    box-shadow: rgb(59, 59, 25) 0px 10px 10px 7px;
    float: left;
    text-align: center;
    color: chocolate;
    height: 70%;
}
.vote{
    padding: 10px;
    font-size: 20px;
}
.input_div{
padding: 10px;
}
.cnd_ids{
    padding-bottom: 10px;
    padding-top: 10px;
    background-color:rgb(35,35,20);
    text-align: center;
    margin:10px 10px 20px 10px;
    color:white;
    box-shadow: rgb(59, 59, 25) 0px 10px 10px 7px;
    border-radius: 5px;
}
.identifications h3{
    color:orange;
    margin-bottom:20px;
}
.cand_name{
    font-size: 20px;
    color:rgb(243, 243, 217);
}
#leftmaindiv{
    height:82%;
    width:45%;
    overflow:auto;
    background-color:gold;
    float:left;
}
</style>
<head>
<body>
<?php include('header.html');?>
<?php include('candidate_validation_errors.php');?>
<div id="leftmaindiv">
    <?php
        //fetch the number of candidates from the database
        $candidates="SELECT n_candidates FROM $account WHERE id=1 LIMIT 1";
        $fetch=mysqli_query($db,$candidates);
        $n=mysqli_fetch_assoc($fetch);
        $number=$n['n_candidates'];
        //openig the loop for page content
        for($i=1;$i<=$number;$i++):
        //fetching the data from database
        $query="SELECT cd_name,cd_age,cd_position,cd_id,cd_gender,cd_email,cd_comment FROM $account WHERE id=$i LIMIT 1";
        $result=mysqli_query($db,$query);
        $text=mysqli_fetch_assoc($result);
        ?>
    <div class="cnd_ids">
          <div class="identifications">
              <h3>NAME</h3>
              <p class="cand_name"><?php echo $text['cd_name'];?></p>
          </div>
          <div class="identifications">
              <h3>AGE</h3>
              <p><?php echo $text['cd_age'];?></p>
          </div>
          <div class="identifications">
              <h3>POSITION</h3>
              <p><?php echo $text['cd_position'];?></p>
          </div>
          <div class="identifications">
              <h3>ID</h3>
              <p><?php echo $text['cd_id'];?></p>

          </div>
          <div class="identifications">
              <h3>GENDER</h3>
              <p><?php echo $text['cd_gender'];?></p>

          </div>
          <div class="identifications">
              <h3>EMAIL</h3>
              <p><?php echo $text['cd_email'];?></p>

          </div>
          <div class="identifications">
              <h3>COMMENT</h3>
              <p><?php echo $text['cd_comment'];?></p>
          </div>
    </div>
   <?php   endfor ;//closing the loop for page content ,division for voting?>
</div>
<form action="voting.php" method="post">
    <div class='subdiv'>
        <h2>VOTE BY YOUR CHOICE THROUGH FILLING CORRECTLY</h2>
        <div class='input_div'>
            <input type='text' class='input_group' name="candidate_id" placeholder='copy your choice candidate id here'/>
        </div> 
        <div class='input_div'>
            <input type='text' class='input_group' name="voter_id" placeholder='type your voter id here'/>
        </div>  
        <div class='input_div'>
        <input type='submit' value="VOTE" class='vote' name='vote'/>
        </div> 
    </div> 
</form> 
<?php include('footer.html')?>
</body>
</html>