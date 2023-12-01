<?php include('admins_engine.php')?>
<?php include('reg_candidate.php');
$voter_num=$_SESSION['n_voters'];
$_SESSION['voters']=$voter_num;
$table=$_SESSION['email'];
$_SESSION['record']=$table;
?>
<html>
<head>
<title>register_election</title>
<link rel="stylesheet" type="text/css" href="register_election.css"/>
</head>
<body>
    <?php include('header.html')?>
    <div class="n_voters">
        <p>fill the given form step by step for further session set up.</p>
        <form method="post" action="register_election.php">
            <label>Enter the number of candidates</label>
            <input type="number" name="n_candidates" id="n_candidates"/><br>
            <input type="submit" value="SEND" name="send" id="nc_send"/>
        </form>
    </div>
    <?php include('candidate_validation_errors.php');?>
    <form id="main_form" action="register_election.php" method="post">
    <?php
    if(isset($_POST['send'])){
        $n_candidates=$_POST['n_candidates'];
    for($i=1;$i<=$n_candidates;$i++){ 
    ?>


    <div class='subdiv'>
        <h2>CANDIDATE <?php echo $i ?> REGISTRATION FORM</h2>
        <div class='input_div'>
            <input type='text' class='input_group' name='cd_name<?php echo $i?>' placeholder='enter the name'/>
        </div>   
        <div class='input_div'>
            <input type='number' class='input_group' name='cd_age<?php echo $i?>' placeholder='enter the age'/>
        </div>   
        <div class='input_div'>
            <input type='text' class='input_group' name='cd_position<?php echo $i?>'  placeholder='enter the postion'/>
        </div> 
        <div class='input_div'>   
            <input type='text' class='input_group'  name='cd_id<?php echo $i?>' placeholder='enter the ID'/>
        </div> 
        <div class='input_div'>
            <select type='text' class='input_group' name='cd_gender<?php echo $i?>'>gender:
            <option>undefined</option>
            <option>male</option>
            <option>female</option>
            </select>
        </div> 
        <div class='input_div'>
            <input type='email' class='input_group' name='cd_email<?php echo $i?>'  placeholder='enter the email'/>
        </div> 
        <div class='input_div'>
            <input type='text' class='input_group' name='cd_comment<?php echo $i?>'  placeholder='add a comment'/>
        </div> 
    </div>
    <?php }}?>
            <input type='number' class='num_candidates' value="<?php echo $i?>" name="num_candidates"/>
    <div class="registdiv">
        <div style="margin: 0 auto; width:fit-content;margin-top:35px;">
        <?php if(count($errors)==0):?>
        <input type='submit' class='reg_btn' value="REGIST" name='regist'/>
        <?php endif ?>
        </div>
    </div>
    </form>
    <?php include('footer.html')?>
</body>
</html>