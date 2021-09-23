<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'vendor/autoload.php';

class User extends CI_Controller {

	public function index($page = 'all'){
		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Semua Pengguna' );
		$vData = Array();
		$fData = Array( 'js' => Array() );

		switch ($page) {
			case 'bought': $hData['title'] = 'Pengguna Yang Pernah Beli'; break;
			case 'neverbought': $hData['title'] = 'Pengguna Belum Pernah Beli'; break;
			default: break;
		}

		$this->load->view('static/head', $hData);
		$this->load->view('user/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function ping(){
		if ( $this->session->userdata('logged_in') != true ){
			echo 403;
		} else {
			echo 200;
		}
	}

	public function changetemppass($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/changetemppass/'. $id .'?key='. API_KEY .'&secret='. $user->secret .'&'. http_build_query($params));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array('status' => 500));
		} else {
			echo $res->getBody();
		}
	}

	public function resignin(){
		$this->load->library('user_agent');

		$postData 	= Array();
		$data 		= $this->input->post();

		$__uuid   = md5($this->agent->agent_string(). time()); 
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		$charactersLength = strlen($characters); 
		$randomString = ''; 
		for ($i = 0; $i < 10; $i++) { 
			$randomString .= $characters[rand(0, $charactersLength - 1)]; 
		} 
		$__uuid   = $randomString . $__uuid; 

		$postData['user'] 		= $data['email'];
		$postData['password']	= $data['password'];

		$postData['uuid']  		= substr($__uuid, 0, 8) .'-';
		$postData['uuid'] 	   .= substr($__uuid, 8, 4) .'-';
		$postData['uuid'] 	   .= substr($__uuid, 12, 4) .'-';
		$postData['uuid'] 	   .= substr($__uuid, 16, 4) .'-';
		$postData['uuid'] 	   .= substr($__uuid, 20, 12);

		$postData['type']		= 'cms';
		$postData['platform']	= $this->agent->platform();
		$postData['version'] 	= $this->agent->version();
		$postData['model'] 		= $this->agent->browser();
		$postData['manufacturer'] = '';

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'user/signin?key='. API_KEY, Array(
			'form_params'	=> $postData));

		if ( $res->getStatusCode() != 200 ){
			if ( $this->input->is_ajax_request() ){
				echo json_encode(Array( 'status' => 300, 'message' => 'Username/email dan password tidak cocok.' ));
			} else {
				$this->session->set_flashdata( 'error', 'Username/email dan password tidak cocok.' );
				$this->session->set_flashdata( 'email', $this->input->post('email') );
				header('Location: '. site_url('user/login'));
			}
		}


		$response = json_decode($res->getBody());
		if ( empty($response->status) or $response->status != 200 ){
			$message = (!empty($response->message)) ? $response->message : 'Internal server error! Mohon coba beberapa saat lagi.';
			if ( $this->input->is_ajax_request() ){
				echo json_encode(Array( 'status' => 300, 'message' => $message ));
			} else {
				$this->session->set_flashdata( 'error', $message );
				$this->session->set_flashdata( 'email', $this->input->post('email') );
				header('Location: '. site_url('user/login'));
			}

		} else {

			$response->result->uuid = $postData['uuid'];
			$this->session->set_userdata( 'logged_in', true );
			$this->session->set_userdata( 'user', $response->result );

			if ( $this->input->is_ajax_request() ){
				echo json_encode(Array('status' => 200));
			} else {
				header('Location: '. site_url());
			}
		}		
	}

	public function patchpolis($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$postData = Array( 'user_id' => $id );

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'patchpolis?key='. API_KEY .'&secret='. $user->secret, Array(
			'form_params'	=> $postData));

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
		}

		// Get provinces
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'provinces?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$provinces = null;
		} else {
			$provinces = json_decode($res->getBody());
		}

		$data->provinces = $provinces->results;
		$data->user_id = $id;


		$hData = Array();
		$vData = Array( 'data' => $data );
		$fData = Array();

		$this->load->view('static/head', $hData);
		$this->load->view('user/patchpolis', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function regeneratepolis($userID){
		$postData = $this->input->post();

		if (empty($postData['family_name'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Nama orang terdekat tidak boleh kosong' ));
			return;
		}
		if (empty($postData['family_phone'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'No. Telp. orang terdekat tidak boleh kosong' ));
			return;
		}
		if (empty($postData['family_email'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Email orang terdekat tidak boleh kosong' ));
			return;
		}
		if (empty($postData['full_name'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Nama lengkap tidak boleh kosong' ));
			return;
		}
		if (empty($postData['pos_code'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Kode Pos tidak boleh kosong' ));
			return;
		}
		if (empty($postData['email'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Email terdekat tidak boleh kosong' ));
			return;
		}
		if (empty($postData['phone'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'No. Telp. tidak boleh kosong' ));
			return;
		}
		if (empty($postData['identity_no'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'No. Identitas tidak boleh kosong' ));
			return;
		}

		$postData['user_id'] = $userID;
		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'regeneratepolis?key='. API_KEY, Array(
			'form_params'	=> $postData));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500 ));
		} else {
			echo $res->getBody();
		}
	}

	public function regeneratepolis2($userID){
		$postData = $this->input->post();

		if (empty($postData['family_name'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Nama orang terdekat tidak boleh kosong' ));
			return;
		}
		if (empty($postData['family_phone'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'No. Telp. orang terdekat tidak boleh kosong' ));
			return;
		}
		if (empty($postData['family_email'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Email orang terdekat tidak boleh kosong' ));
			return;
		}
		if (empty($postData['full_name'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Nama lengkap tidak boleh kosong' ));
			return;
		}
		if (empty($postData['pos_code'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Kode Pos tidak boleh kosong' ));
			return;
		}
		if (empty($postData['email'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'Email terdekat tidak boleh kosong' ));
			return;
		}
		if (empty($postData['phone'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'No. Telp. tidak boleh kosong' ));
			return;
		}
		if (empty($postData['identity_no'])){
			echo json_encode(Array( 'status' => 403, 'message' => 'No. Identitas tidak boleh kosong' ));
			return;
		}

		$postData['user_id'] = $userID;
		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'regeneratepolis2?key='. API_KEY, Array(
			'form_params'	=> $postData));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500 ));
		} else {
			echo $res->getBody();
		}
	}

	public function getcity($provinceID){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'provinces/'. $provinceID .'/regencies?key='. API_KEY .'&secret='. $user->secret .'&'. http_build_query($params));

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
		}

		if (!empty($data->results)){
			foreach ($data->results as $key => $value) {
				echo '<option value="'. $value->id .'">'. $value->name .'</option>';
			}
		}
	}

	public function alluser(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/all?key='. API_KEY .'&secret='. $user->secret .'&'. http_build_query($params));

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('user/content', $vData);
	}

	public function filteruser(){
		$this->load->view('user/filter');
	}

	public function adduser(){
		$this->load->view('user/add');
	}

	public function addadmin($id = 0){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/role?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$role = null;
		} else {
			$role = json_decode($res->getBody());
			if ( $role->status == 200 ) $role = $role->results;
			else $role = null;
		}

		$vData = Array();
		$vData['roles'] = $role;

		if (!empty($id)){
			$res = $client->request('GET', API_URI .'user/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

			if ( $res->getStatusCode() != 200 ){
				$data = null;
			} else {
				$data = json_decode($res->getBody());
				if ( $data->status == 200 ) $data = $data->result;
				else $data = null;
			}

			$vData['data'] = $data;
		}

		$this->load->view('user/addadmin', $vData);
	}

	public function editadmin($id){
		$this->addadmin($id);
	}

	public function edituser($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('user/add', $vData);
	}

	public function viewuser($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('user/view', $vData);
	}

	public function bought(){
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			return;
		}

		$hData = Array(
			'title'	=> 'Pengguna Yang Pernah Beli' );
		$vData = Array( 'users' => null, '__meta' => null );
		$fData = Array( 'js' => Array() );

		$this->load->view('static/head', $hData);
		$this->load->view('user/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function neverbought(){
		$hData = Array(
			'title'	=> 'Pengguna Belum Pernah Beli' );
		$vData = Array( 'users' => null, '__meta' => null );
		$fData = Array( 'js' => Array() );

		$this->load->view('static/head', $hData);
		$this->load->view('user/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function add($id = 0){
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			return;
		}

		$hData = Array(
			'title'	=> 'Add User',
			'css'	=> Array( 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' )
		);
		$fData = Array(
			'js'	=> Array( 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js' )
		);
		$vData = Array();

		if ( !empty($id) ){
			$user = $this->db->get_where( 'users', Array( 'id' => $id ) )->result();
			if (empty($user)){
				$this->load->view('errors/html/error_404');
				return;
			}

			$hData['user'] = $user[0];
			$hData['title'] = $user[0]->first_name .' '. $user[0]->last_name;
		}

		$city = $this->db->get('city')->result();
		foreach ($city as $key => $value) {
			$city[$key]->name = ucwords(strtolower($value->name));
		}
		$vData['city'] = $city;

		$this->load->view('static/head', $hData);
		$this->load->view('user/add', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function edit($id){
		$this->add($id);
	}

	public function profile(){
		$user = $this->session->userdata('user');
		$this->edit($user->id);
	}

	public function login(){
		if ( $this->session->userdata('logged_in') == true ){
			header('Location: '. site_url());
			return;
		}

		$hData = Array(
			'title'	=> 'Sign in',
			'css'	=> Array( '/admin/resources/css/login.css' ));

		$this->load->view('static/head', $hData);
		$this->load->view('user/sign_in');
	}

	public function signing_in(){

		if ( $this->session->userdata('logged_in') == true ){
			header('Location: '. site_url());
			return;
		}

		$this->load->library('user_agent');

		$postData 	= Array();
		$data 		= $this->input->post();

		$__uuid   = md5($this->agent->agent_string(). time()); 
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		$charactersLength = strlen($characters); 
		$randomString = ''; 
		for ($i = 0; $i < 10; $i++) { 
			$randomString .= $characters[rand(0, $charactersLength - 1)]; 
		} 
		$__uuid   = $randomString . $__uuid; 

		$postData['user'] 		= $data['email'];
		$postData['password']	= $data['password'];

		$postData['uuid']  		= substr($__uuid, 0, 8) .'-';
		$postData['uuid'] 	   .= substr($__uuid, 8, 4) .'-';
		$postData['uuid'] 	   .= substr($__uuid, 12, 4) .'-';
		$postData['uuid'] 	   .= substr($__uuid, 16, 4) .'-';
		$postData['uuid'] 	   .= substr($__uuid, 20, 12);

		$postData['type']		= 'cms';
		$postData['platform']	= $this->agent->platform();
		$postData['version'] 	= $this->agent->version();
		$postData['model'] 		= $this->agent->browser();
		$postData['manufacturer'] = '';

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'user/signin?key='. API_KEY, Array(
			'form_params'	=> $postData));

		if ( $res->getStatusCode() != 200 ){
			if ( $this->input->is_ajax_request() ){
				echo json_encode(Array( 'status' => 300, 'message' => 'Username/email dan password tidak cocok.' ));
			} else {
				$this->session->set_flashdata( 'error', 'Username/email dan password tidak cocok.' );
				$this->session->set_flashdata( 'email', $this->input->post('email') );
				header('Location: '. site_url('user/login'));
			}
		}


		$response = json_decode($res->getBody());
		if ( empty($response->status) or $response->status != 200 ){
			$message = (!empty($response->message)) ? $response->message : 'Internal server error! Mohon coba beberapa saat lagi.';
			if ( $this->input->is_ajax_request() ){
				echo json_encode(Array( 'status' => 300, 'message' => $message ));
			} else {
				$this->session->set_flashdata( 'error', $message );
				$this->session->set_flashdata( 'email', $this->input->post('email') );
				header('Location: '. site_url('user/login'));
			}

		} else {

			$response->result->uuid = $postData['uuid'];
			$this->session->set_userdata( 'logged_in', true );
			$this->session->set_userdata( 'user', $response->result );

			if ( $this->input->is_ajax_request() ){
				echo json_encode(Array('status' => 200));
			} else {
				header('Location: '. site_url());
			}
		}
	}

	public function saveadmin(){
		$data = $this->input->post();
		if (empty($data['role'])){
			echo json_encode(Array('status' => 403, 'message' => 'Anda belum memilih role admin'));
			return;
		}
		$this->save(true);
	}

	public function save($isAdmin = false){
		if ( $this->session->userdata('logged_in') != true ){
			if ($this->input->is_ajax_request()){
				echo json_encode(Array('status' => 403, 'message' => 'Session kadaluarsa silahkan login kembali'));
				return;
			}

			header('Location: '. site_url('user/login'));
			return;
		}

		$user = $this->session->userdata('user');
		$data = $this->input->post();

		$requiredFields = Array( 'full_name', 'email', 'phone', 'username' );
		foreach ($requiredFields as $key => $value) {
			if (empty($data[$value])){
				echo json_encode(Array('status' => 403, 'message' => ucfirst(str_replace('_', ' ', $value)) .' can not be blank'));
				return;
			}
		}

		if (empty($data['id']) || !empty($data['password'])){
			if (strlen($data['password']) < 8){
				echo json_encode(Array('status' => 403, 'message' => 'Password minimal 8 karakter'));
				return;
			}

			if ($data['password'] != $data['password2']){
				echo json_encode(Array('status' => 403, 'message' => 'Password yang anda masukan tidak sama'));
				return;
			}
		}

		$client = new \GuzzleHttp\Client();
		$uri = API_URI .'user/add?key='. API_KEY .'&secret='. $user->secret;

		$res = $client->request('POST', $uri, Array('form_params'	=> $data));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 300, 'message' => 'Internal server error! Mohon coba beberapa saat lagi.' ));
			return;
		}

		$response = json_decode($res->getBody());
		if ( $response->status == 200 and !empty($_FILES) and !empty($_FILES['image']) ){
			$userID = $response->result->id;
			$res = $client->request('POST', API_URI .'user/'. $userID .'/addphoto?key='. API_KEY .'&secret='. $user->secret, Array(
    			'multipart' => Array(
    				Array(
			            'name'     	=> 'image',
		    	        'contents' 	=> fopen($_FILES['image']['tmp_name'], 'r'),
		    	        'filename'	=> $_FILES['image']['name'],
		    	        'headers'  	=> Array( 'Content-Type' => $_FILES['image']['type'] )
		    	    )
    			)
    		));

			if ( $res->getStatusCode() != 200 ){
				echo json_encode(Array( 'status' => 300, 'message' => 'Data sukses tersimpan, tetapi upload foto gagal, coba beberapa saat lagi.' ));
				return;
			}

			$addPhotoRes = json_decode($res->getBody());
			echo json_encode($addPhotoRes);
			return;
		}

		echo json_encode($response);
	}

	public function delete( $id ){
		if ( $this->session->userdata('logged_in') != true ){
			echo json_encode(Array( 'status' => 403, 'You need login.' ));
			return;
		}

		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/'. $id .'/delete?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500, 'message' => 'Internal server error' ));
		} else {
			echo $res->getBody();
		}
	}

	public function ban( $id ){
		if ( $this->session->userdata('logged_in') != true ){
			echo json_encode(Array( 'status' => 403, 'You need login.' ));
			return;
		}

		$this->load->model('Usermodel');
		echo ( $this->Usermodel->ban($id) )
			? json_encode(Array( 'status' => 200 ))
			: json_encode(Array( 'status' => 500 ));
	}

	public function unban( $id ){
		if ( $this->session->userdata('logged_in') != true ){
			echo json_encode(Array( 'status' => 403, 'You need login.' ));
			return;
		}

		$this->load->model('Usermodel');
		echo ( $this->Usermodel->unban($id) )
			? json_encode(Array( 'status' => 200 ))
			: json_encode(Array( 'status' => 500 ));
	}

	public function logout(){
		$this->session->sess_destroy();
		$this->session->set_userdata('logged_out', true);
		header('Location: '. site_url());
	}

	public function verify($token){
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/verify?key='. API_KEY .'&token='. $token);

		if ( $res->getStatusCode() == 200 ){
		}

		header('Location: /verified');
	}

	public function admin(){
		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Semua Pengguna' );
		$vData = Array();
		$fData = Array( 'js' => Array() );

		$this->load->view('static/head', $hData);
		$this->load->view('user/admin', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function role(){
		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Admin Role' );
		$vData = Array();
		$fData = Array( 'js' => Array() );

		$this->load->view('static/head', $hData);
		$this->load->view('user/role', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function alladmin(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/admin?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('user/admincontent', $vData);
	}

	public function rolecontent(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/role?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('user/rolecontent', $vData);
	}

	public function addrole(){
		$this->load->view('user/addrole');
	}

	public function editrole($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/role/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('user/addrole', $vData);
	}

	public function saverole(){
		$user = $this->session->userdata('user');
		$data = $this->input->post();
		$data['id'] = (int) $data['id'];

		if (empty($data['name'])){
			echo json_encode(Array('status' => 403, 'message' => 'Nama role tidak boleh kosong'));
			return;
		}

		foreach ($data as $key => $value) {
			if ($value === 'on') $data[$key] = 1;
		}

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'user/role?key='. API_KEY .'&secret='. $user->secret, Array(
			'form_params'	=> $data));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array('status' => 500, 'message' => 'Tidak dapat terhubung ke server'));
			return;
		}


		$response = json_decode($res->getBody());
		if ( empty($response->status) or $response->status != 200 ){
			$message = (!empty($response->message)) ? $response->message : 'Internal server error! Mohon coba beberapa saat lagi.';
			echo json_encode(Array( 'status' => 500, 'message' => $message ));
			return;
		}

		echo json_encode(Array('status' => 200));
	}

	public function deleterole($id){
		$user = $this->session->userdata('user');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('DELETE', API_URI .'user/role/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500, 'message' => 'Internal server error, mohon coba beberapa saat lagi.' ));
			return;
		}

		$data = json_decode($res->getBody());
		echo json_encode($data);
	}

	public function viewrole($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'user/role/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('user/viewrole', $vData);
	}
}
