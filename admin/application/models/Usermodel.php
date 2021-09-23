<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usermodel extends CI_Model {

	private function __hash_password( $password ){
		return md5( 'fdf_add_doc_javascript('. $password .')' ) .'-'. substr(md5($password), 0, 20). '__';
	}

	public function get( $params = array() ){

		if ( isset($params['q']) ){
			$this->db->group_start()
				->like( 'first_name', $params['q'] )
				->or_like( 'last_name', $params['q'] )
				->group_end();
		}

		if ( isset($params['id']) )
			$this->db->where( 'id', $params['id'] );

		$this->db->where( 'deleted', 0 );
		$limit = (isset($params['limit'])) ? $params['limit'] : 12;
		$this->db->limit($limit);
		$this->db->order_by('id', 'desc');
		$data = $this->db->get( 'users' )->result();
		if ( empty($data) ) return null;
		foreach ($data as $key => $value) {
			unset($data[ $key ]->password);
			unset($data[ $key ]->email_verify_token);
		}

		return $data;
	}


	public function getMeta( $params = array() ){
		$limit = (isset($params['limit'])) ? $params['limit'] : 12;

		if ( isset($params['q']) ){
			$this->db->group_start()
				->like( 'first_name', $params['q'] )
				->or_like( 'last_name', $params['q'] )
				->group_end();
		}
		if ( isset($params['id']) )
			$this->db->where( 'id', $params['id'] );
		$this->db->where( 'deleted', 0 );

		$count_all = $this->db->get('users')->num_rows();

		$__meta = new stdClass();
		$__meta->count_all = $count_all;
		$__meta->limit = $limit;
		$__meta->page_count = ceil($count_all/$limit);
		return $__meta;
	}

	public function register( $data ){

		if ( empty($data['first_name']) )
			return Array( 'status' => 300, 'message' => 'First name can not be blank.' );
		if ( empty($data['last_name']) )
			return Array( 'status' => 300, 'message' => 'Last name can not be blank.' );
		if ( empty($data['email']) )
			return Array( 'status' => 300, 'message' => 'Email can not be blank.' );
		if ( !filter_var($data['email'], FILTER_VALIDATE_EMAIL) )
			return Array( 'status' => 300, 'message' => 'Email address not valid.' );

		if ( empty($data['edit_id']) or (!empty($data['password']) and !empty($data['edit_id']) ) ){
			if ( strlen($data['password']) < 8 )
				return Array( 'status' => 300, 'message' => 'Password minimal 8 characters.' );
			if ( $data['password'] != $data['password2'] )
				return Array( 'status' => 300, 'message' => 'Password did not match.' );
		}

		$is_admin = (!empty($data['is_admin']) and $data['is_admin'] == 1) ? 1 : 0;
		$dbData = Array(
			'first_name'			=> $data['first_name'],
			'last_name'				=> $data['last_name'],
			'email'					=> $data['email'],
			'is_admin'				=> $is_admin );

		if ( empty($data['edit_id']) ){
			$dbData['registered_date']		= time();
		}

		if ( isset($data['profile_picture']) )
			$dbData['profile_picture'] = $data['profile_picture'];
		if ( isset($data['profile_picture_thumb']) )
			$dbData['profile_picture_thumb'] = $data['profile_picture_thumb'];

		if ( isset($data['city']) )
			$dbData['city'] = $data['city'];

		if ( empty($data['edit_id']) or (!empty($data['password']) and !empty($data['edit_id']) ) ){
			$dbData['password'] = $this->__hash_password( $data['password'] );
		}

		if ( empty($data['edit_id']) ){

			if ( $this->isEmailRegistered($data['email']) )
				return Array( 'status' => 300, 'message' => 'Email sudah terdaftar.' );

			$result =  $this->db->insert( 'users', $dbData );
			$user = $this->session->userdata( 'user' );
			$this->Activitymodel->add( $user->id, 
				'Add new user ('. $dbData['first_name'] .' '. $dbData['last_name'] .').',
				site_url( 'user' ) );
		} else {
			$user = $this->session->userdata( 'user' );
			$this->Activitymodel->add( $user->id, 
				'Edit user ('. $dbData['first_name'] .' '. $dbData['last_name'] .').',
				site_url( 'user' ) );
			$result =  $this->db->update( 'users', $dbData, Array( 'id' => $data['edit_id'] ) );
		}

		if ( $result ){
			return Array( 'status' => 200 );
		} else {
			return Array( 'status' => 500, 'message' => 'Internal server error, mohon coba lagi nanti' );
		}
	}

	public function isEmailRegistered( $email ){
		return ( $this->db->get_where( 'users', Array( 'email' => $email ) )->num_rows() > 0 );
	}

	public function adminLogin( $email, $password ){
		$user = $this->db->get_where( 'users', Array( 
			'is_admin' 	=> 1, 
			'deleted'	=> 0,
			'banned'	=> 0,
			'email' 	=> $email, 
			'password' 	=> $this->__hash_password( $password ) ) )->result();

		if ( !isset($user[0]) ) return Array( 'status' => 403, 'message' => 'Email dan password tidak cocok' );

		$this->db->update( 'users', Array( 'last_login' => time() ), Array( 'id' => $user[0]->id ));
		unset( $user[0]->password );
		return Array( 'status' => 200, 'user' => $user[0] );
	}


	public function delete($id){
		if ( empty($id) ) return false;

		$user_target = $this->db->get_where( 'users', Array( 'id' => $id ) )->result();
		if ( !isset($user_target[0]) ) return false;
		$user = $this->session->userdata( 'user' );
		$this->Activitymodel->add( $user->id, 
			'Delete user ('. $user_target[0]->first_name .' '. $user_target[0]->last_name .').',
			site_url( 'user' ) );

		return $this->db->update( 'users', Array( 'deleted' => 1 ), Array( 'id' => $id ) );
	}

	public function ban($id){
		if ( empty($id) ) return false;

		$user_target = $this->db->get_where( 'users', Array( 'id' => $id ) )->result();
		if ( !isset($user_target[0]) ) return false;
		$user = $this->session->userdata( 'user' );
		$this->Activitymodel->add( $user->id, 
			'Ban user ('. $user_target[0]->first_name .' '. $user_target[0]->last_name .').',
			site_url( 'user' ) );

		return $this->db->update( 'users', Array( 'banned' => 1 ), Array( 'id' => $id ) );
	}
	public function unban($id){
		if ( empty($id) ) return false;

		$user_target = $this->db->get_where( 'users', Array( 'id' => $id ) )->result();
		if ( !isset($user_target[0]) ) return false;
		$user = $this->session->userdata( 'user' );
		$this->Activitymodel->add( $user->id, 
			'Unban user ('. $user_target[0]->first_name .' '. $user_target[0]->last_name .').',
			site_url( 'user' ) );

		return $this->db->update( 'users', Array( 'banned' => 0 ), Array( 'id' => $id ) );
	}
}