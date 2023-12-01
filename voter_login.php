<?php include('voter_login_engine.php')?>
<html>
<head>
<title>sinup_org</title>
<link rel="stylesheet" type="text/css" href="login.css"/>
</head>
<body>
<form action="voter_login.php" method="post" class="sinup_form">
<h1>LOG IN FOR VOTING WITH:</h1>
    <?php include('validation_errors.php');?>

    <div class="input_group">
        <label class="label">ADMIN email</label>
        <input type="email" name="email" class="input"/>
    </div>
<h2>or</h2>
    <div class="input_group">
        <label class="label">org/community name</label>
        <input type="text" name="org_comm_name" class="input"/>
    </div>
    <div class="input_group">
        <button type="submit" name="login_voter">LOGIN</button>
    </div>
    <a href="help.html" class="lastlink"><p class="lastp">don't know both?</p></a>
</form>

</body>
</html>