<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.12.2017
 * Time: 19:43
 */
echo $this->formHelper->createForm(
    "addBlog",
    "/Bonziblog/addBlog",
    "POST"
);
?>

<div class="addBlog">

    <?php echo $this->formHelper->inputGroup('title', 'form-element','text', ['label' => 'Title', 'maxlength' => 32]); ?>
    <?php echo $this->formHelper->inputGroup('content', 'form-element','text', ['label' => 'Text', 'maxlength' => 4200],"textarea"); ?>
    <?php echo $this->formHelper->inputGroup('image', 'form-element','file', ['label' => 'Image']); ?>
    <button class="btn" name="form-submit" id="form-submit">Create Blog</button>
</div>

<?php echo $this->formHelper->endForm(); ?>

