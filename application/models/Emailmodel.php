<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'vendor/autoload.php';
use Mailgun\Mailgun;

class Emailmodel extends CI_Model {

	private $mgClient;
	private $mgFrom;

	public function __construct(){
		parent::__construct();

		$this->mgClient = new Mailgun( MAILGUN_KEY );
		$this->mgFrom 	= 'Pro Warriors <support@'. MAILGUN_DOMAIN .'>';
	}


	/**
	 * Send an email
	 * @param Array $to[ first_name, last_name, email ]
	 */
	public function sendEmail( $to, $subject, $message ){

		$_m_to = $to['name'] .' <'. $to['email'] .'>';
		$_m_message = '<div style="background: #151515;padding: 30px 0;"><div style="margin: 30px auto 10px; max-width: 600px; word-wrap: break-word;">'
			. '<div style="background: #ccc; padding: 4px; box-shadow: 1px 1px 8px #999;">'
			. '<div style="border: #bd2027 1px solid; background: #222; padding: 30px 40px; color: #d5d5d5;">'

			. '<h3 style="margin: 10px 0 20px;">Hi '. $to['name'] .'!</h3>'

			. $message

			. '<br /><p style="margin-bottom:0;">Regards,<br />ProWarriors Admin</p>'

			. '</div>'
			. '</div>'
			. '</div><div style="max-width: 600px; margin: 0 auto;font-size: 90%; color: #999;"><p>&copy; 2017 ProWarriors</p></div></div>';

		return $this->mgClient->sendMessage(MAILGUN_DOMAIN, array(
		    'from'    => $this->mgFrom,
		    'to'      => $_m_to,
		    'subject' => $subject,
		    'html'    => $_m_message
		));

	}
}