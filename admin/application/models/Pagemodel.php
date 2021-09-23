<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagemodel extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	private function _genSlug( $title = null, $id = 0 ){

		if ( $title == null ){
			$slug 	= 'page-private-preview';
		} else{
			$slug 	= strtolower(preg_replace('/[ ]|[^a-zA-Z0-9]/', '-', $title));
			$slug 	= $this->_removeSlugStripe( $slug );
		}

		if ( !empty($id) ) 
			$this->db->where( 'id !=', $id );
		$this->db->where( 'slug', $slug );
		$x_data = $this->db->get('page')->num_rows();
		if ( $x_data > 0 ){
			$slug 	= $slug .'-'. $x_data;
			return $this->_genSlug( $slug );
		}
		return $slug;
	}

	private function _removeSlugStripe( $slug ){
		$slug = str_replace('--', '-', $slug);
		if ( strstr($slug, '--') )
			return $this->_removeSlugStripe( $slug );
		return $slug;
	}



	public function get( $params = array() ){

		if ( isset($params['id']) )
			$this->db->where( 'id', $params['id'] );
		if ( isset($params['slug']) )
			$this->db->where( 'slug', $params['slug'] );
		if ( isset($params['is_publish']) )
			$this->db->where( 'is_publish', $params['is_publish'] );

		$this->db->order_by('id', 'desc');
		$dataAll = $this->db->get( 'page' )->result();
		if ( empty($dataAll) ) return null;

		foreach ($dataAll as $key_data => $data) {

			/** 
			 * Get author data
			 *
			 */
			$this->db->select( 'first_name, last_name, about, profile_picture, profile_picture_thumb' );
			$author = $this->db->get_where( 'users', Array( 'id' => $data->author ) )->result();
			if ( empty($author) )
				unset($dataAll[ $key_data ]);
			$dataAll[ $key_data ]->author = $author[0];

			// Header image
			if ( !empty($data->header_image) ){
				$headerImage = $this->db->get_where( 'media', Array( 'id' => $data->header_image ) )->result();
				if ( !empty($headerImage) )
					$dataAll[ $key_data ]->header_image = $headerImage[0];
				else
					$dataAll[ $key_data ]->header_image = 0;
			}

			/**
			 * Content
			 *
			 */
			if ( !isset($params['content']) or $params['content'] == true ){
				$this->db->where( 'page_id', $data->id );
				$content = $this->db->get( 'page_content' )->result();
				$dataAll[ $key_data ]->content = $content[0]->content;
			}
		}

		return $dataAll;
	}

	public function save( $data ){

		$user = $this->session->userdata('user');

		if ( !empty($data['id']) ){

			$pageID = $data['id'];

			$dbData = Array(
				'tags'				=> $data['tags'],
				'header_image'		=> $data['header_image'],
				'last_edited_by'	=> $user->id,
				'last_edited_date'	=> time(),
				'last_edited_ip'	=> $this->input->ip_address(),
				'slug'				=> $this->_genSlug( $data['title'], $pageID ),
				'is_publish'		=> $data['is_publish'],
				'featured'			=> 0,
				'title'				=> $data['title'],
				'subtitle'			=> $data['subtitle']
			);

			$this->db->update('page', $dbData, Array( 'id' => $pageID ));

			// Update content
			$this->db->update('page_content', Array( 'content' => trim($data['content']) ), Array( 'page_id' => $pageID ));

			return Array( 'status' => 200, 'edit_id' => $pageID, 'slug' => $dbData['slug'] );

		} else {

			$dbData = Array(
				'tags'				=> $data['tags'],
				'header_image'		=> $data['header_image'],
				'author'			=> $user->id,
				'last_edited_by'	=> $user->id,
				'publish_date'		=> time(),
				'created_date'		=> time(),
				'last_edited_date'	=> time(),
				'last_edited_ip'	=> $this->input->ip_address(),
				'slug'				=> $this->_genSlug( $data['title'] ),
				'is_publish'		=> $data['is_publish'],
				'featured'			=> 0,
				'view_count'		=> 0,
				'title'				=> $data['title'],
				'subtitle'			=> $data['subtitle']
			);

			$this->db->insert('page', $dbData);
			$pageID = $this->db->insert_id();

			// Update content
			$this->db->insert('page_content', Array( 'page_id' => $pageID, 'content' => trim($data['content']) ));
			return Array( 'status' => 200, 'edit_id' => $pageID, 'slug' => $dbData['slug'] );
		}
	}

}