<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Notifications\TokenNotification;

class ghasedakChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toghasedakSms($notifiable);
        $receptor = $data["phone_number"];
        $message = $data["text"];
        $api_key = env('GHASEDAK_API_KEY');
        try {
            $lineNumber = "10008566";
            $receptor = "09011092352";
            $api = new \Ghasedak\GhasedakApi($api_key);
            $api->SendSimple($receptor, $message, $lineNumber);
        } catch (\Ghasedak\Exceptions\ApiException $e) {
            throw $e;
        } catch (\Ghasedak\Exceptions\HttpException $e) {
            throw $e;
        }
    }
}
