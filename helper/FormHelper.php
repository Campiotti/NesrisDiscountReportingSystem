<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 25.10.2017
 * Time: 10:46
 */

namespace helper;

class FormHelper extends BaseHelper
{

    public function createForm(string $name,
                               string $action,
                               string $method = 'POST',
                               string $id = "",
                               string $class="form",
                               array $options = []
    ):string{
        return "<form action='$action' method='$method' name='$name' id='$id' class='$class' enctype=\"multipart/form-data\">";
    }

    public function inputGroup(string $name, string $classes, string $type,array $options = [], $extra="input"){
        if(!isset($options['label'])){
            $options['label']="";
        }
        if(!isset($options['placeholder'])){
            $options['placeholder']="";
        }
        if(!isset($options['required'])){
            $options['required']=false;
        }
        if(!isset($options['id'])){
            $options['id']=$name;
        }
        if(!isset($options['onchange'])){
            $options['onchange']="";
        }
        if(!isset($options['onkeyup'])){
            $options['onkeyup']="";
        }
        if(!isset($options['maxlength'])){
            $options['maxlength']=null;
        }
        $this->renderer->setAttribute('name', $name);
        $this->renderer->setAttribute('classes', $classes);
        $this->renderer->setAttribute('type', $type);
        $this->renderer->setAttribute('options', $options);
        $this->renderer->setAttribute('labelText', $options['label']);
        if(isset($options['placeholder'])){
            $this->renderer->setAttribute('placeholder',$options["placeholder"]);
        }
        if(isset($options['required'])){
            $this->renderer->setAttribute('required',$options['required']);
        }
        $this->renderer->setAttribute('maxlength',$options['maxlength']);
        $this->renderer->setAttribute('onchange',$options['onchange']);
        $this->renderer->setAttribute('onkeyup',$options['onkeyup']);
        $this->renderer->setAttribute('id',$options['id']);
        $this->renderer->setAttribute('extra',$extra);
        $this->renderer->renderByFileName('input-group.php');
    }
    public function labelInput(string $name, string $classes, string $type,array $options = [], $extra="input"){
        if(!isset($options['label'])){
            $options['label']="";
        }
        if(!isset($options['placeholder'])){
            $options['placeholder']="";
        }
        if(!isset($options['required'])){
            $options['required']=false;
        }
        if(!isset($options['id'])){
            $options['id']=$name;
        }
        if(!isset($options['onchange'])){
            $options['onchange']="";
        }
        if(!isset($options['onkeyup'])){
            $options['onkeyup']="";
        }
        if(!isset($options['maxlength'])){
            $options['maxlength']=null;
        }
        $this->renderer->setAttribute('name', $name);
        $this->renderer->setAttribute('classes', $classes);
        $this->renderer->setAttribute('type', $type);
        $this->renderer->setAttribute('options', $options);
        $this->renderer->setAttribute('labelText', $options['label']);
        if(isset($options['placeholder'])){
            $this->renderer->setAttribute('placeholder',$options["placeholder"]);
        }
        if(isset($options['required'])){
            $this->renderer->setAttribute('required',$options['required']);
        }
        $this->renderer->setAttribute('maxlength',$options['maxlength']);
        $this->renderer->setAttribute('onchange',$options['onchange']);
        $this->renderer->setAttribute('onkeyup',$options['onkeyup']);
        $this->renderer->setAttribute('id',$options['id']);
        $this->renderer->setAttribute('extra',$extra);
        $this->renderer->renderByFileName('label-input.php');
    }

    public function input(
        string $name,
        string $classes,
        string $type,
        array $options = []
    ){
        return "<input type='$type' name='$name' class='$classes'>";
    }

    public function endForm():string{
        return "</form>";
    }

}