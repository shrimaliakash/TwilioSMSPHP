The following URL to download PHP twilio libraries in the local system.
    https://www.twilio.com/docs/libraries/php

    Use Following Command For Manual Download:

    Go to the command prompt for the Twilio Project and type the following commands for download twilio api in PHP.

    If the composer does not install in the system then follow step 1 otherwise start step2.
    sudo apt install composer
    composer require twilio/sdk
    Create one file for SendSMS.php and write the following code in that file.
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

    Create one file for ReceiveSMS.php and write the following code in that file.
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

    Use Command line run file with following commands:
    php SendSMS.php
    php ReceiveSMS.php

    Unable to create record: Permission to send an SMS has not been enabled for the region indicated by the 'To' number: +17063882263.
    For this error go to settings -> geo-permissions and click USA checkbox and then run api or script in command line