<?php

use Webit\Api\SmsCommon\Sender\SmsSenderInterface;
use Webit\Api\SmsCommon\Message\SmsInterface;

class PhantomSmsSender implements SmsSenderInterface {
    /**
     * 
     * @param SmsInterface $sms
     */
    public function sendSms(SmsInterface $sms) {
        // I'm doing nothing. I'm phantom, man!    
    }
}
