<?php

session_start();

if(isset($_SESSION["alg_user"])){

    $_SESSION["alg_user"] = null;
    session_destroy();
    echo("signedout");

}
