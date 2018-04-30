<?php echo $this->formHelper->createForm(
    "user",
    "/user/add",
    "POST"
); ?>


    <?php echo $this->formHelper->inputGroup('username', 'form-control', ['label' => 'Benutzername']); ?>
    <?php echo $this->formHelper->inputGroup('firstname', 'form-control', ['label' => 'Vorname']); ?>
    <?php echo $this->formHelper->inputGroup('lastname', 'form-control', ['label' => 'Nachname']); ?>



<?php echo $this->formHelper->endForm(); ?>
