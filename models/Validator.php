<?php

namespace models;

class Validator
{
    /*private $validationConfiguration = [
        'firstname' => [
            'required' => true,
            'maxLength' => 20
        ],
        'registerDate'=>[
            'isDate' => true
        ]
    ];*/
    private $entity;
    private $isValid = true;
    private $validationConfiguration = [];
    /*private $errors = [
        'firstname' => [
            'required' => 'Firstname cannot be left empty.'
        ]
    ];*/
    private $errors = [];

    /**
     * Validator constructor.
     * @param $entity
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }


    public function isRequired($property, $bool = true)
    {
        $this->addPropertyIfNotExistent($property);
        $this->validationConfiguration[$property]['required'] = $bool;
    }

    public function maxLength($property, $number)
    {
        $this->addPropertyIfNotExistent($property);
        $this->validationConfiguration[$property]['maxLength'] = $number;
    }

    public function isDate($property, $bool = true)
    {
        $this->addPropertyIfNotExistent($property);
        $this->validationConfiguration[$property]['isDate'] = $bool;
    }

    private function addPropertyIfNotExistent($property)
    {
        if (!isset($this->validationConfiguration[$property])) {
            $this->validationConfiguration[$property] = [];
        }
    }
    public function isMail($property, $bool = true){
        $this->addPropertyIfNotExistent($property);
        $this->validationConfiguration[$property]['isMail']=$bool;
    }

    public function minLength($property, $number)
    {
        $this->addPropertyIfNotExistent($property);
        $this->validationConfiguration[$property]['minLength'] = $number;
    }

    public function validate(): bool
    {
        $this->isValid = true;
        foreach ($this->validationConfiguration as $propertyName => $propertyConfiguration) {
            if (isset($propertyConfiguration['required']) && $propertyConfiguration['required'] == true) {
                $this->checkIsRequiredFullfilled($propertyName);
            }
            if (isset($propertyConfiguration['maxLength']) && $propertyConfiguration['maxLength'] > 0) {
                $bool = strlen($this->entity->$propertyName) <= $propertyConfiguration['maxLength'];
                if ($bool == false) {
                    $this->isValid = false;
                }
            }
            if (isset($propertyConfiguration['isDate']) && $propertyConfiguration['isDate'] == true) {
                if (!$this->entity->$propertyName instanceof \DateTime) {
                    $this->isValid = false;
                }
            }
            if(isset($propertyConfiguration['isMail']) && $propertyConfiguration['isMail'] ==true){
                if(preg_match(FILTER_VALIDATE_EMAIL,$this->entity->$propertyName)){
                    $this->isValid=false;
                }
            }
            if (isset($propertyConfiguration['isDate']) && $propertyConfiguration['isDate'] == false) {
                if ($this->entity->$propertyName instanceof \DateTime) {
                    $this->isValid = false;
                }
            }
            if (isset($propertyConfiguration['minLength']) && $propertyConfiguration['minLength'] > 0) {
                $bool = strlen($this->entity->$propertyName) >= $propertyConfiguration['minLength'];
                if ($bool == false) {
                    $this->isValid = false;
                }
            }
        }
        return $this->isValid;
    }


    private function checkIsRequiredFullfilled(string $propertyName)
    {
        if ($this->isValid) {
            $this->isValid = !empty($this->entity->$propertyName);
            if ($this->isValid == false) {
                $this->errors[$propertyName] = ucfirst($propertyName) . " cannot be left empty";
            }
        }
    }

}