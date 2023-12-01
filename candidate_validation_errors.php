
<?php if(count($errors)>0):?>
<div>
<h1 style="color:red;text-align:center">Oohps; the following errors blocked the form submission:</h1>
<?php foreach($errors as $error):?>
<p  style="margin-left:50px;"><?php echo $error?></p>
<?php endforeach ?>
</div>
<?php endif ?>