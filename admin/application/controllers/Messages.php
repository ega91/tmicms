<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'vendor/autoload.php';

class Messages extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			exit();
		}
	}

	public function secret(){
		$user = $this->session->userdata('user');
		echo json_encode(Array( 
			'status' => 200, 
			'id' 	 => $user->id, 
			'secret' => $user->secret, 
			'uuid' 	 => $user->uuid ));
	}

	public function index(){
		$user = $this->session->userdata('user');
		if ($user->role_data->message < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Message' );
		$vData = Array( 'data' => null );
		$fData = Array( 'js' => Array());

		$this->load->view('static/head', $hData);
		$this->load->view('message/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function broadcast(){
		$user = $this->session->userdata('user');
		if ($user->role_data->broadcast < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Broadcast Message' );
		$vData = Array( 'data' => null );
		$fData = Array( 'js' => Array());

		$this->load->view('static/head', $hData);
		$this->load->view('message/broadcast', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function inbox(){
		$user = $this->session->userdata('user');
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'message/am_inbox?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('message/inbox', $vData);
	}

	public function conv($id){
		$user = $this->session->userdata('user');
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'message/'. $id .'/am_cnv?_to='. $this->input->get('_to') .'&key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data, 'sender' => $this->input->get('sender') );
		$this->load->view('message/conv', $vData);
	}
}