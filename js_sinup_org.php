<?php include('admins_engine.php')?>
<html>
<head>
<title>sinup_org</title>
<link rel="stylesheet" type="text/css" href="sin_up.css"/>
<script>
    function validation_f(){
        var bug;
        var org_comm_name=document.forms['form']['org_comm_name'].value;
        var email=document.forms['form']['email'].value;
        var password_1=document.forms['form']['password_1'].value;
        var password_2=document.forms['form']['password_2'].value;
        if(password_1!=password_2){
        bug ="passwords are not matching";
        }
        if(email.length>=100){
        bug +=  "  " + "email character can't excceed 100";
        }
        if(org_comm_name.length>=100){
        bug +=  "  " + "org_comm_name character can't excceed 100";  
        }
        if(bug != null){  
        alert(bug);
        return false;
        }
    
    }
    </script>
</head>
<body>
<form action="js_sinup_org.php"  method="post" name="form" onsubmit="return validation_f()" class="sinup_form">
<h1>SINUP FOR ADMIN ACCOUNT</h1>
    <?php include('validation_errors.php');?>
    <div class="input_group">
        <label class="label">organisation/community name</label>
        <input type="text" name="org_comm_name" value="<?php echo $org_comm_name ?>" class="input" required/>
    </div>

    <div class="input_group">
        <label class="label">ADMIN email</label>
        <input type="email" name="email" value="<?php echo $email ?>" class="input" required/>
    </div>

    <div class="input_group">
        <label class="label">Password</label>
        <input type="password" name="password_1"  class="input" required/>
    </div>

    <div class="input_group">
        <label class="label">confirm password</label>
        <input type="password" name="password_2" class="input" required/>
    </div>
    <div class="input_group">
        <label class="label">number of voters</label>
        <input type="number" name="n_voters" value="<?php echo $n_voters ?>" min="2" max="100000" class="input" required/>
    </div>
    <div class="input_group">
        <button type="submit" name="sinup_admin">SIN UP</button>
    </div>
    <a href="admin_login.php" class="lastlink"><p class="lastp">login if have account</p></a>

</form>
</body>
</html>