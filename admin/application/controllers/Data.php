<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			exit();
		}
	}

	public function index(){
		$this->load->view('errors/html/error_404');
	}


	public function featured( $parent ){
		$this->load->model('Postmodel');
		$data = $this->Postmodel->getSimple( Array( 'parent' => $parent, 'is_publish' => 1, 'featured' => 1 ) );

		$parent = $this->Postmodel->getParentBySlug($parent);
		if ( empty($parent) ){
			$this->load->view('errors/html/error_404');
			return;
		}

		$hData = Array( 
			'title' 	=> 'Featured from '. $parent->name );
		$vData = Array( 
			'title' 	=> 'Featured from '. $parent->name, 
			'page' 		=> 'featured', 
			'data' 		=> $data,
			'parent'	=> $parent );
		$fData = Array( 'js' => Array() );
		$vData['category'] 	= false;

		$this->load->view('static/head', $hData);
		$this->load->view('post/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function draft( $parent ){
		$this->load->model('Postmodel');
		$data = $this->Postmodel->getSimple( Array( 'parent' => $parent, 'is_publish' => 0 ) );

		$vData = Array( 
			'title' 	=> 'Draft', 
			'page' 		=> 'draft', 
			'data' 		=> $data,
			'parent'	=> $parent );
		$fData = Array( 'js' => Array() );

		$this->load->view('static/head');
		$this->load->view('post/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function getcat( $parentID ){
		$this->load->model('Postmodel');
		$vData['category'] 	= $this->Postmodel->getCategories($parentID);
		$this->load->view('post/category', $vData);
	}

	public function refresh( $id ){
		$this->load->model('Postmodel');
		$data = $this->Postmodel->getSimple( Array( 'id' => $id));

		$vData = Array( 
			'data' 		=> $data );
		$this->load->view('post/all_data', $vData);
	}

	public function add( $parent ){

		$user = $this->session->userdata('user');

		/**
		 * Template for blank post with 1 section
		 *
		 */
		$data = new stdClass();
		$data->sections = Array( new stdClass() );
		$data->sections[0]->order_number = 1;


		$this->load->model('Postmodel');

		$vData = Array( 
			'data' 			=> $data, 
			'user' 			=> $user,
			'author'		=> $user,
			'post_parent'	=> $this->Postmodel->getParentBySlug( $parent ) );

		$vData['data']->parent = $vData['post_parent'];

		$hData = Array( 'css' => Array() );
		$hData['css'][] = site_url('resources/css/medium-editor.min.css');
		$hData['css'][] = site_url('resources/css/themes/beagle.min.css');
		$fData = Array( 'js' => Array() );
		$fData['js'][] = site_url('resources/js/medium-editor.js');
		$fData['js'][] = site_url('resources/js/html.sortable.min.js');

		$vData['category'] 	= $this->Postmodel->getCategories($vData['post_parent']->id);

		$this->load->view('static/head', $hData);
		$this->load->view('post/add', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function edit( $id ){

		$user = $this->session->userdata('user');

		$this->load->model('Postmodel');
		$data = $this->Postmodel->get( Array( 'id' => $id ));
		if ( empty($data) ){
			$this->load->view('errors/html/error_404');
			return;
		}

		$vData = Array( 
			'data' 			=> $data[0], 
			'user' 			=> $user,
			'author'		=> $data[0]->author,
			'post_parent'	=> $this->Postmodel->getParent( $id ) );

		$vData['data']->parent = $vData['post_parent'];

		$hData = Array( 'css' => Array() );
		$hData['css'][] = site_url('resources/css/medium-editor.min.css');
		$hData['css'][] = site_url('resources/css/themes/beagle.min.css');
		$fData = Array( 'js' => Array() );
		$fData['js'][] = site_url('resources/js/medium-editor.js');
		$fData['js'][] = site_url('resources/js/html.sortable.min.js');

		$vData['category'] 	= $this->Postmodel->getCategories($vData['post_parent']->id);

		if ( $vData['post_parent']->slug == 'trips' ){
			$vData['calendar'] = $this->db->get_where('events', Array( 'post_id' => $data[0]->id ))->result();
		}

		$this->load->view('static/head', $hData);
		$this->load->view('post/add', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function confirm_delete($id){
		$this->session->set_userdata( 'post_will_delete', $id );
	}

	public function delete( $id ){
		if ( $id != $this->session->userdata( 'post_will_delete' ) ){
			echo json_encode(Array( 'status' => 404, 'message' => 'Delete failed! Data can not be found.' ));
			return;
		}

		$this->load->model('Postmodel');
		$this->session->unset_userdata( 'post_will_delete' );
		echo json_encode($this->Postmodel->delete($id));
	}

	public function newcontent(){
		$vData = Array(
			'section_idx'	=> $this->input->get('section_idx'),
			'content_idx'	=> $this->input->get('content_idx') );
		$this->load->view('post/_content-'. $this->input->get('content_type'), $vData);
	}

	public function newsection(){
		$section_idx = (int) $this->input->get('section_idx');
		if ( empty($section_idx) ) return;
		$this->load->view('post/add_section', Array( 'section_idx' => $section_idx ));
	}

	public function save(){
		$this->load->model('Postmodel');
		$result = $this->Postmodel->save($this->input->post());

		if ( $this->input->is_ajax_request() ){
			echo json_encode($result);
		} else {
			header('Location: '. site_url('data/edit/'. $result['edit_id']));
		}
	}

	private function _removeSlugStripe( $slug ){
		$slug = str_replace('--', '-', $slug);
		if ( strstr($slug, '--') )
			return $this->_removeSlugStripe( $slug );
		return $slug;
	}

	private function __genCatSlug( $name, $id = null ){

		$slug 	= strtolower(preg_replace('/[ ]|[^a-zA-Z0-9]/', '-', $name));
		$slug 	= $this->_removeSlugStripe( $slug );

		$this->db->where( 'slug', $slug );
		if ( !empty($id) )
			$this->db->where( 'id !=', $id );
		$x_data = $this->db->get('post_category')->num_rows();
		if ( $x_data > 0 ){
			$slug 	= $slug .'-'. $x_data;
			return $this->__genCatSlug( $slug );
		}
		return $slug;
	}	

	public function addcategory( $parent ){
		$data = $this->input->post();
		if ( empty($data['cat']) ){
			echo json_encode(Array( 'status' => 401 ));
			return;
		}

		$dbData = Array(
			'name'			=> $data['cat'],
			'slug'			=> $this->__genCatSlug($data['cat']),
			'description'	=> '',
			'post_parent'	=> $parent );
		$this->db->insert( 'post_category', $dbData );
		echo json_encode(Array( 'status' => 200, 'id' => $this->db->insert_id() ));
	}

	public function editcat($id){
		$data = $this->input->post();
		if ( empty($data['cat']) ){
			echo json_encode(Array( 'status' => 401 ));
			return;
		}

		$dbData = Array(
			'name'			=> $data['cat'],
			'slug'			=> $this->__genCatSlug($data['cat'], $id) );
		$this->db->update( 'post_category', $dbData, Array( 'id' => $id ) );
		echo json_encode(Array( 'status' => 200 ));
	}

	public function deletecat($id){
		$this->load->model('Postmodel');
		echo json_encode($this->Postmodel->deleteCategory($id));
	}

	public function publish( $id ){
		$this->load->model('Postmodel');
		echo json_encode($this->Postmodel->publish($id));
	}

	public function setfeatured( $id ){
		$this->load->model('Postmodel');
		echo json_encode($this->Postmodel->setfeatured($id));
	}

	public function unsetfeatured( $id ){
		$this->load->model('Postmodel');
		echo json_encode($this->Postmodel->unsetfeatured($id));
	}
}
