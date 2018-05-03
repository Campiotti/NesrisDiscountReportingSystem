<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 27.01.2018
 * Time: 09:57
 */
?>
<div class="content">
    <div class="container_12">
        <div class="grid_12">
            <?php if(!isset($_SESSION['User'])){?>
            <h3><span>Login</span></h3>
            <?php echo $this->formHelper->createForm("user","/user/login","POST","Login"); ?>
            <div class="success_wrapper">
                <div class="success">Debug<br>
                    <strong>You are now logged in!</strong>
                </div>
            </div>
            <fieldset>
                <label class="username">
                    <input type="text" name="username" placeholder="Username">
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid name.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="password">
                    <input type="password" name="password" placeholder="Password">
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid phone number.</span><span class="empty error-empty">*This field is required.</span> </label>
                <div class="btns">
                    <button type="submit" class="btn">Login</button>
                </div>
            </fieldset>
            <?php echo $this->formHelper->endForm(); ?>
            <h3><span>Register</span></h3>
            <?php echo $this->formHelper->createForm("user","/user/register","POST","Register"); ?>
            <div class="success_wrapper">
                <div class="success">Data submitted!<br>
                    <strong>You can now login with your username and password</strong>
                </div>
            </div>
            <fieldset>
                <label class="username">
                    <input type="text" name="username" placeholder="Username" required maxlength="16">
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid name.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="password">
                    <input type="password" name="password" placeholder="Password" minlength="6" maxlength="40">
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid phone number.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="email">
                    <input type="email" name="email" placeholder="E-mail" required>
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid email address.</span><span class="empty error-empty">*This field is required.</span> </label>
                <div class="btns">
                    <!--<button type="reset" class="btn">Clear</button>-->
                    <button type="submit" class="btn">Register</button>
                </div>
            </fieldset>
            <?php echo $this->formHelper->endForm(); ?>
            <?php }else{ $user = $this->sessionManager->getSessionArray('User');?>
                <h3><span><?php echo$user['firstname']." ".$user['lastname']?>'s Profile</span></h3>
                <?php $reports=$this->reports; $amount=0;?>
                <?php echo $this->formHelper->createForm("user","/user/edit/".$user['id'],"POST","Edit"); ?>
                <fieldset>
                    <div class="success_wrapper">
                        <div class="success">Data submitted!<br>
                            <strong>Your data has been updated!</strong>
                        </div>
                    </div>
                    <fieldset>
                        <label class="username">
                            <input type="text" name="username" placeholder="Username" value="<?php echo$user['Username']?>" required maxlength="16">
                            <br class="clear">
                            <span class="error error-empty">*This is not a valid name.</span><span class="empty error-empty">*This field is required.</span> </label>
                        <label class="email">
                            <input type="email" name="email" placeholder="E-mail" value="<?php echo$user['Email']?>" required>
                            <br class="clear">
                            <span class="error error-empty">*This is not a valid email address.</span><span class="empty error-empty">*This field is required.</span> </label>
                        <label class="email">
                            <input type="password" name="new_password" placeholder="new password" value="">
                            <br class="clear">
                            <span class="error error-empty">*This is not a valid email address.</span><span class="empty error-empty">*This field is required.</span> </label>
                        <label class="email">
                            <input type="password" name="current_password" placeholder="current password" value="" required>
                            <br class="clear">
                            <span class="error error-empty">*This is not a valid Jeff.</span><span class="empty error-empty">*This field is required.</span> </label>
                        <div class="btns">
                            <!--<button type="reset" class="btn">Clear</button>-->
                            <button type="submit" class="btn">Edit</button>
                        </div>
                </fieldset>
                <?php echo $this->formHelper->endForm(); ?>
                <h2><span>Logout</span></h2>
                <div class="center">
                    <div class="buttons">
                        <a class="btn" type="submit" href="/user/logout">Logout</a>
                    </div>
                </div>
            </div>
        <div class="grid_12">
                    <h3><span>Your assigned Reports </span></h3>
        <div class="text1 center" id="show1" style="display: none">You have assigned reports yet.</div>
                    <?php if (count($reports)>0){ foreach($reports as $report){$amount++?>
                        <div class="grid_12 split" id="<?php echo"vid".$report['id']?>">
                            <div class="grid_4 extra_wrapper">
                                <div class="title"><?php echo$report['title']?></div>
                                <ul class="list2" id="favourites">
                                    <li>Customer: <a href="/report/customerView/<?php echo$report['cid']?>"><?php echo$report['firstname']." ".$report['lastname']?></a></li>
                                    <li>Expenses: <?php echo (array_key_exists($report['id'],$this->expenses)) ? $this->htmlHelper->formatPrice($this->expenses[$report['id']],0) : 'none yet'?></li>
                                    <li>ActivityCosts: <?php echo (array_key_exists($report['id'],$this->activities)) ? $this->htmlHelper->formatPrice($this->activities[$report['id']],0) : 'none yet'?></li>
                                    <li><button class="btn" onClick="location.href='/report/delete/<?php echo$report['id']?>'">Delete Report</button>
                                    <button class="btn" onclick="location.href='/report/view/<?php echo$report['id']?>'" disabled>Details</button>
                                        <!--<button class="btn" onclick="location.href='/report/view/<?php //echo $report['id']?>'">View</button>-->
                                    </li>
                                    <li>
                                        <button class="btn" onclick="location.href='/activity/add/<?php echo $report['id']?>'" disabled>Add Activity</button>
                                        <button class="btn" onclick="location.href='/expense/add/<?php echo $report['id']?>'" disabled>Add Expense</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php }?>
            <?php }else{?>
                        <div class="text1 center" id="show1">You have no assigned reports yet.</div>
                    <?php }}?>
        </div>
    </div>
    <div class="dontLook" id="dontLook"><?php echo$amount?></div>
    </div>


