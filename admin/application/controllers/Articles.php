<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'vendor/autoload.php';

class Articles extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			exit();
		}
	}

	public function index(){

		$user   = $this->session->userdata('user');
		if ($user->role_data->view_article < 1){
			header('Location: /error/404');
			return;
		}


		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'articles?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$data 	= $data;
		$parent = new stdClass();
		$parent->id 	= 1;
		$parent->name 	= 'Article';
		$parent->slug 	= 'article';

		$hData = Array( 
			'title' 	=> 'Article' );
		$vData = Array( 
			'page' 		=> 'all', 
			'data' 		=> $data,
			'parent'	=> $parent );
		$fData = Array( 'js' => Array() );
		$vData['category'] 	= null;

		$this->load->view('static/head', $hData);
		$this->load->view('post/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function add($id = null){

		$user   = $this->session->userdata('user');
		if ($user->role_data->edit_article < 1){
			header('Location: /error/404');
			return;
		}

		$user = $this->session->userdata('user');

		if ( empty($id) ){
			/**
			 * Template for blank post with 1 section
			 *
			 */
			$data = new stdClass();
			$data->sections = Array( new stdClass() );
			$data->sections[0]->order_number = 1;

		} else {
			$client = new \GuzzleHttp\Client();
			$res = $client->request('GET', API_URI .'article/'. $id .'/nocss?key='. API_KEY .'&secret='. $user->secret);

			if ( $res->getStatusCode() != 200 ){
				echo '<p>Internal server error! Mohon coba beberapa saat lagi.</p>';
				echo '<a href="'. site_url() .'">Kembali ke halaman utama</a>';
				return;
			}

			$data = json_decode($res->getBody());
			if ( $data->status != 200 ){
				echo $data->message;
				return;
			}

			$data = $data->result;
		}

		$parent = new stdClass();
		$parent->id 	= 1;
		$parent->name 	= 'Article';
		$parent->slug 	= 'article';

		$vData = Array( 
			'data' 			=> $data, 
			'user' 			=> $user,
			'author'		=> $user,
			'post_parent'	=> $parent );

		$vData['data']->parent = $vData['post_parent'];

		$hData = Array( 'css' => Array() );
		$hData['css'][] = site_url('resources/css/medium-editor.min.css');
		$hData['css'][] = site_url('resources/css/themes/beagle.min.css');
		$fData = Array( 'js' => Array() );
		$fData['js'][] = site_url('resources/js/medium-editor.js');
		$fData['js'][] = site_url('resources/js/html.sortable.min.js');

		$vData['category'] 	= null;

		$this->load->view('static/head', $hData);
		$this->load->view('post/add', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function edit($id){
		$this->add($id);
	}

	public function save(){
		$user = $this->session->userdata('user');
		$data = $this->input->post();

		$description = strip_tags($data['content']);
		if ( !empty($description) ){
			$data['description'] = substr(str_replace('  ', ' ', trim($description)), 0, 240);
		} else {
			$data['description'] = '';
		}

		$publish_date = $data['date'] .' '. $data['time'];
		$data['publish_timestamp'] = strtotime($publish_date);

		$client = new \GuzzleHttp\Client();

		$res = $client->request('POST', API_URI .'article?key='. API_KEY .'&secret='. $user->secret, Array(
			'form_params'	=> $data));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 300, 'message' => 'Internal server error! Mohon coba beberapa saat lagi.' ));
			return;
		}

		$response = json_decode($res->getBody());
		echo json_encode($response);
	}
}
