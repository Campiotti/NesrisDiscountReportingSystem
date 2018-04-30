<?php echo $this->formHelper->createForm("user","/user/add","POST"); ?>

<div class="logincontainer">

    <?php echo $this->formHelper->inputGroup('username', 'form-control','text', ['label' => 'Username']); ?>
    <?php echo $this->formHelper->inputGroup('email', 'form-control','text', ['label' => 'Email']); ?>
    <?php echo $this->formHelper->inputGroup('password', 'form-control','password', ['label' => 'Password']); ?>

    <button class="btn btn-primary" type="submit">Register</button>
</div>

<?php echo $this->formHelper->endForm(); ?>
