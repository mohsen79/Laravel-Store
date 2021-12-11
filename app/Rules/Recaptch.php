<?php

namespace App\Rules;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Recaptch implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $client = new Client();
            $response = $client->request(
                'POST',
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'form_params' => [
                        'secret' => env('GOOGLE_RECAPTCHA_SECRET_KEY'),
                        'response' => $value,
                        'remoteip' => request()->ip()
                    ]
                ]
            );
            $response = json_decode($response->getBody());
            return $response->success;
        } catch (\Exception $e) {
            return false;
        }
        // $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'secret' => env("GOOGLE_RECAPTCH_SECRET_KEY"),
        //     'response' => $value,
        //     'remoteip' => request()->ip()
        // ]);
        // $response->throw();
        // $response->json();
        // return $response['success'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
