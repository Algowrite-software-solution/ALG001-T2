<?php

class request_handler
{
    // validate the request methods
    // post
    public static function isPostMethod()
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
                if (!isset($_POST[$value]) || empty(trim($_POST[$value]))) {
                    return "invalid request method parameters";
                }
            }
        } else {
            return "invalid method";
        }
    }

    public static function getMethodHas(...$variables)
    {
        if (self::isGetMethod()) {
            foreach ($variables as $value) {
                if (!isset($_GET[$value]) || empty(trim($_GET[$value]))) {
                    return "invalid request method parameters";
                }
            }
        } else {
            return "invalid method";
        }
    }
}
