<?php

final class data_validator
{

    private $data;
    private $errorObject;

    function __construct($data)
    {
        $this->data = $data;
        $this->errorObject = new stdClass();
    }

    public function validate()
    {
        foreach ($this->data as $key => $valueArray) {

            // validate as an integer
            if ($key == "id_int") {
                foreach ($valueArray as $valueObject) {
                    $this->id_int_validator($valueObject);
                }
            }

            // validate as an email
            if ($key == "email") {
                foreach ($valueArray as $valueObject) {
                    $this->email_validator($valueObject);
                }
            }
        }

        return $this->errorObject;
    }


    // id validator as integer
    private function id_int_validator($dataToValidate)
    {
        $key = $dataToValidate->datakey;
        $value = $dataToValidate->value;

        // id integer validation rules
        if (is_numeric($value) && intval($value) == $value && $value >= 0) {
            $this->errorObject->$key = null;
        } else {
            $this->errorObject->$key =  "Invalid id for " . $key;
        }
    }

    // id validator as integer
    private function email_validator($dataToValidate)
    {
        $key = $dataToValidate->datakey;
        $value = $dataToValidate->value;


        // Remove leading/trailing white spaces
        $email = trim($value);

        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errorObject->$key = null;
        } else {
            $this->errorObject->$key =  "Invalid Email for " . $key;
        }
    }
}
