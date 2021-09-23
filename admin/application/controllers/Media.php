<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'vendor/autoload.php';

class Media extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			exit();
		}
	}

	public function index(){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_media < 1){
			header('Location: /error/404');
			return;
		}

		$user = $this->session->userdata('user');
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'media?key='. API_KEY .'&secret='. $user->secret);

		$media = null;
		if ( $res->getStatusCode() == 200 ){
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $media = $data->results;
		}

		$hData = Array( 'title'	=> 'Image Library' );
		$vData = Array( 'media' => $media );
		$fData = Array( 'js' => Array() );

		if ( $this->input->is_ajax_request() ){
			// if ( !empty($vData['media']) )
			// 	$this->load->view('media/gallery_item', $vData);
			return;
		}

		$this->load->view('static/head', $hData);
		$this->load->view('media/gallery', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function selector(){
		$user = $this->session->userdata('user');
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'media?key='. API_KEY .'&secret='. $user->secret);

		$media = null;
		if ( $res->getStatusCode() == 200 ){
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $media = $data->results;
		}

		$vData = Array( 'media' => $media );
		$this->load->view('media/selector', $vData);
	}

	public function upload(){

		$user = $this->session->userdata('user');

		if ( empty($_FILES) ){
			echo json_encode(Array('status' => 403, 'message' => 'Anda belum memilih gambar.'));
			return;
		}

		$files = $_FILES;
    	$cpt = count($_FILES['images']['name']);
    	for($i=0; $i<$cpt; $i++){

			$client = new \GuzzleHttp\Client();
			$res = $client->request('POST', API_URI .'media?key='. API_KEY .'&secret='. $user->secret, Array(
    			'multipart' => Array(
    				Array(
			            'name'     	=> 'image',
		    	        'contents' 	=> fopen($_FILES['images']['tmp_name'][$i], 'r'),
		    	        'filename'	=> $_FILES['images']['name'][$i],
		    	        'headers'  	=> Array( 'Content-Type' => $_FILES['images']['type'][$i] )
		    	    )
    			)
    		));

			if ( $res->getStatusCode() != 200 ){
				echo json_encode(Array( 'status' => 300, 'message' => 'Upload foto gagal. Internal server error.' ));
				return;
			}

			$addPhotoRes = json_decode($res->getBody());
			if ( $addPhotoRes->status != 200 ){
				if ( !empty($addPhotoRes->message) )
					echo json_encode($addPhotoRes);
				else
					echo json_encode(Array( 'status' => 301, 'message' => 'Upload foto gagal. Internal server error.' ));
				return;
			}
		}

		echo json_encode(Array( 'status' => 200 ));
	}

	public function get( $id ){

		$user = $this->session->userdata('user');
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'media/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		$media = null;
		if ( $res->getStatusCode() == 200 ){
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $media = $data->result;
		}

		if ( empty($media) ){
			echo json_encode(Array( 'status' => 404, 'message' => '404 - Media tidak ditemukan' ));
			return;
		}

		echo json_encode(Array( 'status' => 200, 'image' => $media ));
	}

	public function delete($id){
		$this->load->model( 'Mediamodel' );
		echo ( $this->Mediamodel->delete($id) )
			? json_encode(Array( 'status' => 200 ))
			: json_encode(Array( 'status' => 500 ));
	}

	public function edit(){
		$data = $this->input->post();
		if ( empty($data['edit_id']) ){
			echo json_encode(Array( 'status' => 404, 'message' => 'Media not found.' ));
			return;
		}

		$dbData = Array(
			'title'			=> $data['title'],
			'description'	=> $data['description'],
			'caption'		=> $data['caption'],
			'alt_text'		=> $data['alt_text'] );
		$this->db->update( 'media', $dbData, Array( 'id' => $data['edit_id'] ) );
		echo json_encode(Array( 'status' => 200 ));
	}
}
