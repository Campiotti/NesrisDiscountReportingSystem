<div class="form-group">
    <label for=""><?php echo $this->labelText ?></label>
    <<?PHP echo $this->extra ?> <?php if($this->maxlength){echo'maxlength="'.$this->maxlength.'"';}?> name="<?PHP echo $this->name ?>" id="<?php echo$this->id?>"<?php echo $this->attributes ?> class="<?php echo $this->classes ?>" type="<?php echo $this->type ?>" placeholder="<?php echo$this->placeholder;?>" onkeyup="<?php echo$this->onkeyup; ?>" <?php echo($this->required ? 'required' : '') ?> onchange="<?php echo$this->onchange; ?>" ><?PHP if($this->extra!="input"){echo"</".$this->extra.">";}?>
</div>