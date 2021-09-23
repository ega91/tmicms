<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			exit();
		}
	}

	public function index(){
		$vData = Array();

		$hData = Array(
			'css'	=> Array() );
		$fData = Array(
			'js'	=> Array() );

		$this->load->view('static/head', $hData);
		$this->load->view('page/index', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function add(){
	}

	public function view( $slug ){
		$this->load->model('Pagemodel');
		$user = $this->session->userdata('user');
		$data = $this->Pagemodel->get( Array( 'slug' => $slug ));

		if ( $slug == 'why-pranko' ){
			$data = $this->Pagemodel->get( Array( 'id' => 1 ));
		} elseif ( $slug == 'kenapa-pranko' ){
			$data = $this->Pagemodel->get( Array( 'id' => 2 ));
		}

		if ( empty($data) ){
			$this->load->view('errors/html/error_404');
			return;
		}

		$vData = Array( 
			'data' 			=> $data[0], 
			'user' 			=> $user );

		$hData = Array( 'css' => Array() );
		$hData['css'][] = site_url('resources/css/medium-editor.min.css');
		$hData['css'][] = site_url('resources/css/themes/beagle.min.css');
		$fData = Array( 'js' => Array() );
		$fData['js'][] = site_url('resources/js/medium-editor.js');
		$fData['js'][] = site_url('resources/js/html.sortable.min.js');

		$this->load->view('static/head', $hData);
		$this->load->view('page/add', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function save(){
		$this->load->model('Pagemodel');
		$result = $this->Pagemodel->save($this->input->post());

		if ( $this->input->is_ajax_request() ){
			echo json_encode($result);
		} else {
			header('Location: '. site_url('page/view/'. $result['edit_id']));
		}
	}

}