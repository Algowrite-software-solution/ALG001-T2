<?php 

class response_sender {

    public static function sendJson ($responseObject){

        echo(json_encode($responseObject));


    }

}

response_sender::sendJson($responseObject);

?>

