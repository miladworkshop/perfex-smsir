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

/*
Module Name: ماژول پیامک ایده پردازان ( sms.ir )
Description: ارسال پیامک‌های سیستم از طریق سامانه پیامکی ایده پردازان ( sms.ir )
Author: میلاد مالدار
Version: 1.0.0
Requires at least: 2.9.*
Author URI: https://miladworkshop.ir
*/

define('SMSIR_MODULE_NAME', 'smsir');

hooks()->add_filter('module_'.SMSIR_MODULE_NAME.'_action_links', 'module_smsir_action_links');

function module_smsir_action_links($actions)
{
	$actions[] = '<a href="' . admin_url('settings?group=sms') . '">' . _l('settings') . '</a>';

	return $actions;
}

register_activation_hook(SMSIR_MODULE_NAME, 'smsir_activation_hook');

function smsir_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

$CI  =&get_instance();
$CI->load->library(SMSIR_MODULE_NAME . '/sms_smsir');