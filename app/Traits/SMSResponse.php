<?php
namespace App\Traits;

use Craftsys\Msg91\Facade\Msg91;

trait SMSResponse{
    

    protected function sendOTPSMS($templateId = null, $flowId = null, $phone, $otp){

        try {
            Msg91::sms()
            ->to($phone) // set the mobiles with country code
            ->flow($flowId) // set the flow id
            ->variable('otp', $otp) // the the value for variable "date" in your flow message template
            ->send();

            // Msg91::otp()
            // ->to($phone) // phone number with country code
            // ->template($templateId) // set the otp template
            // ->send(); // send
            return true;
        } catch (\Craftsys\Msg91\Exceptions\ValidationException $e) {
            // issue with the request e.g. token not provided
            echo "Token error".$e->getMessage();
        } catch (\Craftsys\Msg91\Exceptions\ResponseErrorException $e) {
            // error thrown by msg91 apis or by http client
            echo "Http client error".$e->getMessage();
        } catch (\Exception $e) {
            echo "Something went wrong".$e->getMessage();
            // something else went wrong
            // plese report if this happens :)
        }

        
    }


    protected function sendNormalSMS($templateId = null, $flowId = null, $phone){

        try {
            Msg91::sms()
            ->to($phone) // set the mobiles with country code
            ->flow($flowId) // set the flow id
            ->send();

            // Msg91::otp()
            // ->to($phone) // phone number with country code
            // ->template($templateId) // set the otp template
            // ->send(); // send
            return true;
        } catch (\Craftsys\Msg91\Exceptions\ValidationException $e) {
            // issue with the request e.g. token not provided
            echo "Token error".$e->getMessage();
        } catch (\Craftsys\Msg91\Exceptions\ResponseErrorException $e) {
            // error thrown by msg91 apis or by http client
            echo "Http client error".$e->getMessage();
        } catch (\Exception $e) {
            echo "Something went wrong".$e->getMessage();
            // something else went wrong
            // plese report if this happens :)
        }

        
    }
}

