<?php 
session_start();
$account=$_SESSION['email'];
include('admin_dash_engine.php');
 //session management state checker
 $state_check="SELECT session_state FROM $account WHERE id=1 LIMIT 1";
 $state_in=mysqli_query($db,$state_check);
 $state_out=mysqli_fetch_assoc($state_in);
 $state=$state_out['session_state'];
   //fetch the number of voters and candidates from the database
   $candidates="SELECT n_candidates,n_voters FROM $account WHERE id=1 LIMIT 1";
   $fetch=mysqli_query($db,$candidates);
   $n=mysqli_fetch_assoc($fetch);
   $number=$n['n_candidates'];
   $totalvotes=$n['n_voters'];
 
  //fetch the number of voters from the database
  $voters="SELECT n_voters FROM $account WHERE id=1 LIMIT 1";
  $fetch_voters=mysqli_query($db,$voters);
  $nu=mysqli_fetch_assoc($fetch_voters);
  $numb=$nu['n_voters'];
  $recorded=$numb+$number;
  $_SESSION['total']=$recorded;
  //check for voting_ids availabity
  $vote_check="SELECT*FROM  $account WHERE n_voters=0";
  $vote_checking=mysqli_query($db,$vote_check);
  //check for already voted ids
  $prog="SELECT*FROM $account WHERE vote_checker='VOTED'";
  $prog_in=mysqli_query($db,$prog);
  $prog_out=mysqli_num_rows($prog_in);
  $progress=$prog_out/$recorded*100;
?>
<html>
    <head>
        <title>outcomes</title>
        <link rel="stylesheet" type="text/css" href="admins_ds.css"/>
    </head>
    <body>
        <?php include('header.html')?>
        <div class="left_div">
            <form action="admins_dash.php" method="post">
                <?php if($state=="paused"):?>
                    <button class="start_stop" type="submit" name="session_manager1">START SESSION</button>
                <?php endif ?>
                <?php if($state=="started"):?>
                    <button class="start_stop2" type="submit" name="session_manager2">END SESSION</button>
                <?php endif ?>
            </form>
            <h3>LATEST UPDATES ABOUT ELECTION</h3>
            <table>
                <tr>
                    <th>candidates</th>
                    <th>votes</th>
                    <th>%</ht>
                </tr>
                <?php
                    //openig the loop for page content
                    for($i=1;$i<=$number;$i++):
                    //fetching the data from database
                    $query="SELECT cd_name,votes FROM $account WHERE id=$i LIMIT 1";
                    $result=mysqli_query($db,$query);
                    $text=mysqli_fetch_assoc($result);
                    ?>
                    <tr>
                        <td><?php echo $text['cd_name'];?></td>
                        <td><?php echo $text['votes'];?></td>
                        <td><?php $percent=$text['votes']/$totalvotes*100; echo $percent;//for calculating the percentage?></td>
                    </tr>
                <?php endfor ?>
               
            </table>
            <?php if($state=="started"):?>
                <h3 style="margin-top:20px;margin-bottom:5px;color:black">session progress</h3>
                <progress class="prog" value="<?php echo $progress ?>" max="100"></progress>
           <?php endif ?>
        </div>
        <div class="right_div">
            <h4>ADMIN TOOLS FOR MANAGING THE VOTE SESSION</h4>
            <?php if($state=="paused"):?>
                <div class="mid_div">
                    <h3>VOTERS IDS</h3>
                    <?php if(mysqli_num_rows($vote_checking)==0):?>
                        <h1 id="votersnotification">PLEASE CREATE THE VOTERS IDS</h1>
                    <?php endif?>
                    <form action="admins_dash.php" method="post">
                        <table id="manual_ids">
                            <caption id="topcaption">FILL WITH MANUAL IDS</caption>
                            <tr>
                                <th>number</th>
                                <th>key</th>
                            </tr>
                            <?php
                                $_SESSION['cand']=$number;
                                $_SESSION['number_voters']=$numb;
                                //openig the loop for page content
                                for($v=1;$v<=$numb;$v++):
                            ?>
                            <tr>
                                <td><?php echo $v ?></td>
                                <td><input type="text" name="manual_input<?php echo $v ?>"/></td>
                            </tr>
                            <?php endfor ?>
                            <caption id="bottomcaption"><input type="submit" class="captionbutton" name="manual_ids_save" value="SAVE"/></caption>
                        </table>
                   </form>
                   <form action="admins_dash.php" method="post">
                        <table id="edit_ids">
                            <caption id="topcaption"> EDIT IDS</caption>
                            <tr>
                                <th>number</th>
                                <th>key</th>
                            </tr>
                            <?php
                                 for($v=$number+1;$v<=$recorded;$v++):
                                     //fetching the data from database
                            $queryv="SELECT voters_id FROM $account WHERE id=$v LIMIT 1";
                            $resultv=mysqli_query($db,$queryv);
                            $textv=mysqli_fetch_assoc($resultv);
                                    
                            ?>
                            <tr>
                                <td><?php echo $v-$number ?></td>
                                <td><input type="text" name="manual_input<?php echo $v ?>" value="<?php echo $textv['voters_id'];?>"/></td>
                            </tr>
                            <?php endfor ?>
                            <caption id="bottomcaption"><input type="submit" class="captionbutton" name="manual_ids_edit" value="EDIT"/></caption>
                        </table>
                   </form>
                </div>
                <div class="back_div">
                    <h3>MANAGE MENU</h3>
                    <?php if(mysqli_num_rows($vote_checking)==0):?>
                        <div class="button">
                            <button type="button" onclick="document.getElementById('manual_ids').style.display='table';document.getElementById('votersnotification').style.display='none'">CREATE VOTERS IDS</button>
                        </div>
                    <?php endif ?>
                    <?php if(mysqli_num_rows($vote_checking)!=0):?>
                        <div class="button">
                            <button type="button" onclick="document.getElementById('edit_ids').style.display='table'">MANAGE IDS</button>
                        </div>
                    <h3 style="margin-top:20px;margin-bottom:5px;color:black">session progress</h3>
                    <progress class="prog" value="<?php echo $progress ?>" max="100"></progress>
                    <?php endif ?>

                </div>
            <?php endif?>
            <?php if($state=="started"):?>
                <div class="actions">
                    <table>
                        <caption>FULL VOTING DATA</caption>
                            <tr>
                                <th>num</th>
                                <th>ID</th>                   
                                <th>VOTE/DIDN'T VOTED</th>
                            </tr>
                            <?php
                                for($v=$number+1;$v<=$recorded;$v++):
                                //fetching the data from database
                                $queryv="SELECT voters_id,vote_checker FROM $account WHERE id=$v LIMIT 1";
                                $resultv=mysqli_query($db,$queryv);
                                $textv=mysqli_fetch_assoc($resultv);
                            ?>
                            <tr>
                                <td><?php echo $v-$number ?></td>
                                <td><?php echo $textv['voters_id'];?></td>
                                <td><?php echo $textv['vote_checker'];?></td>
                            </tr>

                        <?php endfor ?>
                    </table>
                </div>
            <?php endif ?>
    </div>
    <?php include('footer.html')?>
    </body>
</html>