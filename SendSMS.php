<?php
    require_once "vendor/autoload.php";
    include('credentials.php');
    use Twilio\Rest\Client;
    $client = new Client($AccountSid, $AuthToken);

    $from_number = isset($argv[1]) ? $argv[1] : '';
    $to_number = isset($argv[2]) ? $argv[2] : '';
    $message = isset($argv[3]) ? $argv[3] : '';
    try {
        $client->messages->create(
            $to_number,
            array(
                'from' => $from_number,
                'body' => urldecode($message)
            )
        );

        $response = array("success" => true, "message" => "Sent message to $to_number");
        echo json_encode($response);
    }catch(Exception $e){
        $response = array("success" => false, "message" => $e->getMessage());
        echo json_encode($response);
    }
    
?>