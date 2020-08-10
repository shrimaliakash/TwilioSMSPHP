<?php
    require_once "vendor/autoload.php";
    include('credentials.php');
    use Twilio\Rest\Client;
    $client = new Client($AccountSid, $AuthToken);

    $from_number = isset($argv[1]) ? $argv[1] : '';
    $to_number = isset($argv[2]) ? $argv[2] : '';

    try{
        $messages = $client->messages->read(
            array(
                'from' => $from_number,
                'to' => $to_number
            ),100
        );
        $message = array();
        foreach ($messages as $key => $record) {
            $message[$key]['to'] = $record->to;
            $message[$key]['from'] = $record->from;
            $message[$key]['body'] = $record->body;
            $message[$key]['direction'] = $record->direction;
            $message[$key]['sid'] = $record->sid;
            $message[$key]['status'] = $record->status;
        }

        $response = array("success" => true, "message" => $message);
        echo json_encode($response,JSON_FORCE_OBJECT);
    }catch(Exception $e){
        $response = array("success" => false, "message" => $e->getMessage());
        echo json_encode($response);
    }
?>