<?php

## developer - janith nirmal (02-07-2023)
## validatable types 
## --  id_int
## --  email
## --  text_255

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

            // validate as an email
            if ($key == "text_255") {
                foreach ($valueArray as $valueObject) {
                    $this->text_255_validator($valueObject);
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

        // Check if the text is empty
        if (empty($value)) {
            $this->errorObject->$key =  "Empty id for " . $key; // Text is empty
        }

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

        // Check if the text is empty
        if (empty($email)) {
            $this->errorObject->$key =  "Empty email for " . $key; // Text is empty
        }

        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errorObject->$key = null;
        } else {
            $this->errorObject->$key =  "Invalid Email for " . $key;
        }
    }

    // id validator as integer
    private function text_255_validator($dataToValidate)
    {
        $key = $dataToValidate->datakey;
        $value = $dataToValidate->value;


        // Remove leading/trailing white spaces
        $text = trim($value);

        // Check if the text is empty
        if (empty($text)) {
            $this->errorObject->$key =  "Empty text for " . $key; // Text is empty
        }

        // Validate the text length
        $minLength = 1; // Minimum allowed length
        $maxLength = 255; // Maximum allowed length
        $textLength = strlen($text);

        if ($textLength < $minLength || $textLength > $maxLength) {
            $this->errorObject->$key =  "Invalid text length for " . $key; // Text is empty
        }

        $this->errorObject->$key = null; // Text is valid
    }
}
