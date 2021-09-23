<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configmodel extends CI_Model {

	public function articleParents(){
		return $this->db->get('post_parent')->result();
	}

	public function articlePages(){
		return $this->db->get_where('post_parent', Array( 'page' => 1 ))->result();
	}

}

