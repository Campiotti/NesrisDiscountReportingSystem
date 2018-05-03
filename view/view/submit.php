<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 03.05.2018
 * Time: 09:59
 */
?>
<div class="content">
    <div class="container_12">
        <div class="grid_12">
            <h3><span>Create your Report</span></h3>
            <?php echo $this->formHelper->createForm("video","/Report/add","POST","submit"); ?>
            <div class="success_wrapper">
                <div class="success">Data submitted!<br>
                    <strong>Your article can now be bought in the store.</strong>
                </div>
            </div>
            <fieldset>
                <label class="Description">
                    <input name="title" placeholder="Title of Report" required maxlength="128">
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid phone number.</span><span class="empty error-empty">*This field is required.</span> </label>
                <label class="">
                    <select name="customerFk" required>
                        <?php foreach($this->customer as $c){?>
                        <?php echo"<option value='$c[id]'>$c[firstname] $c[lastname]</option> " ?>
                        <?php }?>
                    </select>
                    <br class="clear">
                    <span class="error error-empty">*This is not a valid phone number.</span><span class="empty error-empty">*This field is required.</span> </label>

                <div class="btns">
                    <!--<button type="reset" class="btn">Clear</button>-->
                    <button type="submit" class="btn">Submit Report</button>
                </div>
            </fieldset>
            <?php echo $this->formHelper->endForm(); ?>
        </div>
    </div>
</div>
