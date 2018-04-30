<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 27.01.2018
 * Time: 11:42
 */
?>
<label class="<?php echo $this->lblClass?>">
    <<?PHP echo $this->extra ?> <?php if($this->maxlength){echo'maxlength="'.$this->maxlength.'"';}?> name="<?PHP echo $this->name ?>" id="<?php echo$this->id?>"<?php echo $this->attributes ?> class="<?php echo $this->classes ?>" type="<?php echo $this->type ?>" placeholder="<?php echo$this->placeholder;?>" onkeyup="<?php echo$this->onkeyup; ?>" <?php echo($this->required ? 'required' : '') ?> onchange="<?php echo$this->onchange; ?>" ><?PHP if($this->extra!="input"){echo"</".$this->extra.">";}?>
    <br class="clear">
    <span class="error error-empty">*This is not a valid name.</span><span class="empty error-empty">*This field is required.</span>
</label>
