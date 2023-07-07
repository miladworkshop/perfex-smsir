<?php
/*
 * 	Perfex CRM SMSIR Sms Module
 * 	
 * 	Link 	: https://github.com/miladworkshop/perfex-smsir
 * 	
 * 	Author 	: Milad Maldar
 * 	E-mail 	: info@miladworkshop
 * 	Website : https://miladworkshop.ir
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Sms_smsir extends App_sms
{
    private $from;
    private $api_key;

    public function __construct()
    {
        parent::__construct();

        $this->from 	= $this->get_option('smsir', 'from');
        $this->api_key 	= $this->get_option('smsir', 'api_key');

        $this->add_gateway('smsir', [
            'name'    => 'ایده پردازان ( sms.ir )',
            'info'    => "<p>ارسال کلیه پیامک‌های سیستم از طریق سامانه پیامکی <a href='https://sms.ir' target='_blank'>ایده پردازان ( sms.ir )</a> - طراحی و توسطعه داده شده توسط <a href='https://miladworkshop.ir' target='_blank'>میلاد مالدار</a></p><hr class='hr-10'>",
            'options' => [
                [
                    'name'  => 'from',
                    'label' => 'شماره فرستنده',
                ],
				[
                    'name'  => 'api_key',
                    'label' => 'کلید API',
                ],
            ],
        ]);
    }

    public function send($number, $message)
    {
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL 			=> 'https://api.sms.ir/v1/send/bulk',
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_ENCODING 		=> '',
			CURLOPT_MAXREDIRS 		=> 10,
			CURLOPT_TIMEOUT 		=> 0,
			CURLOPT_FOLLOWLOCATION 	=> true,
			CURLOPT_SSL_VERIFYPEER 	=> false,
			CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST 	=> 'POST',
			CURLOPT_POSTFIELDS 		=> '{
				"lineNumber": '. $this->from .',
				"messageText": "'. $message .'",
				"mobiles": ["'. $number .'"],
				"sendDateTime": null
			}',
			CURLOPT_HTTPHEADER => array("Content-Type: application/json", "X-API-KEY: {$this->api_key}"),
		));

		$response = curl_exec($curl);
		$response = json_decode($response, true);

		curl_close($curl);

		return (isset($response['status']) && $response['status'] == 1) ? true : false;
    }
}
