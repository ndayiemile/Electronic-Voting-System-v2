<?php include('admins_engine.php')?>
<html>
<head>
<title>sinup_org</title>
<link rel="stylesheet" type="text/css" href="sin_up.css"/>
</head>
<body>
<form action="admin_login.php" method="post" class="sinup_form">
<h1>LOG IN ADMIN ACCOUNT</h1>
    <?php include('validation_errors.php');?>
    <div class="input_group">
        <label class="label">ADMIN email</label>
        <input type="email" name="email" value="<?php echo $email ?>" class="input" required/>
    </div>

    <div class="input_group">
        <label class="label">password</label>
        <input type="password" name="password" class="input" required/>
    </div>
    <div class="input_group">
        <button type="submit" name="login_admin">LOGIN</button>
    </div>
    <a href="js_sinup_org.php" class="lastlink"><p class="lastp">login if have account</p></a>
</form>

</body>
</html>