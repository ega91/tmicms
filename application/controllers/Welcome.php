<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'vendor/autoload.php';
use Mailgun\Mailgun;

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$vData = Array(
			'css'	=> Array( '/resources/lightslider/css/lightslider.min.css' ),
			'js'	=> Array( '/resources/lightslider/js/lightslider.min.js' ));


		$this->load->view('welcome', $vData);
	}

	public function proccesingpayment(){
		echo '<html lang="id-ID"><head><meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body>';
		echo '<h4 style="text-align: center; position: absolute; left: 20px; right: 20px; top: 50%; margin-top: -20px;">Memproses pembayaran...</h3>';
		echo '</body></html>';
	}

	public function verify($token){
		header('Location: /admin/verify/'. $token);
	}

	public function verified(){
		$this->load->view('verified');
	}

	public function privacy(){
		$this->load->view('privacy');
	}

	public function term(){
		$this->load->view('term');
	}

	public function touringmerdeka(){
		$this->load->view('touringmerdeka');
	}
}
