<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Name:  Twilio
	*
	* Author: Ben Edmunds
	*		  ben.edmunds@gmail.com
	*         @benedmunds
	*
	* Location:
	*
	* Created:  03.29.2011
	*
	* Description:  Twilio configuration settings.
	*
	*
	*/

	/**
	 * Mode ("sandbox" or "prod")
	 **/
	$config['mode']   = 'prod';

	/**
	 * Account SID
	 **/
	
	$config['account_sid']   = 'AC9325c648ca449e524081186b4f6acd03'; //Live Client
	//$config['account_sid']   = ''; //Sandbox Shailesh

	/**
	 * Auth Token
	 **/
	
	$config['auth_token']    = '8b5e0a5ebd70bf57d88bfa4aac5a272e'; //Live Client
	//$config['auth_token']    = ''; //Sandbox shailesh
	
	/**
	 * API Version
	 **/
	$config['api_version']   = '2010-04-01';

	/**
	 * Twilio Phone Number
	 **/
	
	//$config['number']        = '+15005550006';
	$config['number']        = '+15712914290'; //Live Shailesh
	
/* End of file twilio.php */