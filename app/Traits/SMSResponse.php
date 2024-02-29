<?php
namespace App\Traits;

use Craftsys\Msg91\Facade\Msg91;


trait SMSResponse{

    protected function sendOTPSMS($templateId = null, $flowId = null, $phone, $otp){

        // try {
        //     Msg91::sms()
        //     ->to($phone) // set the mobiles with country code
        //     ->flow($flowId) // set the flow id
        //     ->variable('otp', $otp) // the the value for variable "date" in your flow message template
        //     ->send();

        //     // Msg91::otp()
        //     // ->to($phone) // phone number with country code
        //     // ->template($templateId) // set the otp template
        //     // ->send(); // send
        //     return true;
        // } catch (\Craftsys\Msg91\Exceptions\ValidationException $e) {
        //     // issue with the request e.g. token not provided
        //     echo "Token error".$e->getMessage();
        // } catch (\Craftsys\Msg91\Exceptions\ResponseErrorException $e) {
        //     // error thrown by msg91 apis or by http client
        //     echo "Http client error".$e->getMessage();
        // } catch (\Exception $e) {
        //     echo "Something went wrong".$e->getMessage();
        //     // something else went wrong
        //     // plese report if this happens :)
        // }

        $url = 'https://control.msg91.com/api/v5/flow/';
        $headers = array(
            'accept: application/json',
            'authkey: '.env('Msg91_KEY'),
            'content-type: application/json'
        );

        $data = array(
            'template_id' => $flowId,
            'short_url' => '1', // Set to '1' for On or '0' for Off
            'recipients' => array(
                array(
                    'mobiles' => $phone,
                    'otp' => $otp,
                    
                )
            )
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            // Handle response
            return $response;
        }

        curl_close($ch);

        
    }


    protected function sendNormalSMS($templateId = null, $flowId = null, $phone){

        $url = 'https://control.msg91.com/api/v5/flow/';
        $headers = array(
            'accept: application/json',
            'authkey: '.env('Msg91_KEY'),
            'content-type: application/json'
        );

        $data = array(
            'template_id' => $flowId,
            'short_url' => '1', // Set to '1' for On or '0' for Off
            'recipients' => array(
                array(
                    'mobiles' => $phone,
                )
            )
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            // Handle response
            return $response;
        }

        curl_close($ch);

        
    }

    protected function sendWarrantyLinkSMS($flowId = null, $phone, $material, $link){

        $url = 'https://control.msg91.com/api/v5/flow/';
        $headers = array(
            'accept: application/json',
            'authkey: '.env('Msg91_KEY'),
            'content-type: application/json'
        );

        $data = array(
            'template_id' => $flowId,
            'short_url' => '1', // Set to '1' for On or '0' for Off
            'recipients' => array(
                array(
                    'mobiles' => $phone,
                    'P_TYPE' => $material,
                    'URL' => $link
                )
            )
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            // Handle response
            return $response;
        }

        curl_close($ch);

        
    }
    
}

