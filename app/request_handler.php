<?php

class request_handler
{
    // validate the request methods
    // post
    private static function isPostMethod()
    {
        return ($_SERVER["REQUEST_METHOD"] === "POST") ? true : false;
    }

    // get
    public static function isGetMethod()
    {
        return ($_SERVER["REQUEST_METHOD"] === "GET") ? true : false;
    }

    // check for the existant of the given request method parameters
    public static function postMethodHas(...$variables)
    {
        if (self::isPostMethod()) {
            foreach ($variables as $value) {
                $variableName = $_POST[$value];
                if (!isset($variableName) || empty($variableName)) {
                    return "invalid request method parameters";
                } else {
                    return false;
                }
            }
        } else {
            return "invalid method";
        }
    }

    public static function getMethodHas(...$variables)
    {
        if (self::isGetMethod()) {
            $error = "";
            foreach ($variables as $value) {
                if (!isset($_POST[$value]) || empty($_POST[$value])) {
                    $error  = "invalid request method parameters";
                } else {
                    $error = true;
                }
            }
            return $error;
        } else {
            return "invalid method";
        }
    }
}

echo request_handler::getMethodHas("name", "age");
