<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mediamodel extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function get( $params = array() ){

		if ( !empty($params['id']) )
			$this->db->where( 'id', $params['id'] );
		if ( !empty($params['last_id']) )
			$this->db->where( 'id <', $params['last_id'] );

        $this->load->library('image_lib');
		$upload_path = BASEPATH .'../../resources/uploads/';

		$limit = ( isset($params['limit']) ) ? $params['limit']: 12;
		$this->db->limit($limit);
		$this->db->order_by('id', 'desc');
		$data = $this->db->get('media')->result();

		foreach ($data as $key => $value) {

			$data[ $key ]->uploaded_date_str = date( 'j M, Y', $value->uploaded_date );
			$image_path = $upload_path . $value->file_name;

	        if ( $value->height > 1800 ){
		        $config = Array();
				$config['image_library'] 	= 'gd2';
				$config['source_image'] 	= $image_path;
				$config['create_thumb'] 	= false;
				$config['maintain_ratio'] 	= true;
				$config['width']         	= $value->width;
				$config['height']       	= 1800;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
	        }

			if ( empty($value->image_920) ){
		        // Resize image to 920x920
		        $thumb_path_920 = 'thumb/_920x920_'. $value->file_name;
				copy($image_path, $upload_path . $thumb_path_920);
		        $config = Array();
				$config['image_library'] 	= 'gd2';
				$config['source_image'] 	= $upload_path . $thumb_path_920;
				$config['create_thumb'] 	= false;
				$config['maintain_ratio'] 	= true;
				$config['width']         	= 920;
				$config['height']       	= 920;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->db->update( 'media', 
					Array( 'image_920' => '/resources/uploads/'. $thumb_path_920 ),
					Array( 'id' => $value->id ) );
				$data[ $key ]->image_920 = '/resources/uploads/'. $thumb_path_920;
			}

			if ( empty($value->image_270) ){
		        // Resize image to 270x270
		        $thumb_path_270 = 'thumb/_270x270_'. $value->file_name;
				copy($image_path, $upload_path . $thumb_path_270);
		        $config = Array();
				$config['image_library'] 	= 'gd2';
				$config['source_image'] 	= $upload_path . $thumb_path_270;
				$config['create_thumb'] 	= false;
				$config['maintain_ratio'] 	= true;
				$config['width']         	= 270;
				$config['height']       	= 270;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->db->update( 'media', 
					Array( 'image_270' => '/resources/uploads/'. $thumb_path_270 ),
					Array( 'id' => $value->id ) );
				$data[ $key ]->image_270 = '/resources/uploads/'. $thumb_path_270;
			}

			if ( empty($value->image_90) ){
		        // Resize image to 90x90
		        $thumb_path_90 = 'thumb/_90x90_'. $value->file_name;
				copy($image_path, $upload_path . $thumb_path_90);
		        $config = Array();
				$config['image_library'] 	= 'gd2';
				$config['source_image'] 	= $upload_path . $thumb_path_90;
				$config['create_thumb'] 	= false;
				$config['maintain_ratio'] 	= true;
				$config['width']         	= 90;
				$config['height']       	= 90;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->db->update( 'media', 
					Array( 'image_90' => '/resources/uploads/'. $thumb_path_90 ),
					Array( 'id' => $value->id ) );
				$data[ $key ]->image_90 = '/resources/uploads/'. $thumb_path_90;
			}
		}

		return $data;
	}

	public function delete($id){

		if ( empty($id) ) return false;
		$media = $this->db->get_where( 'media', Array( 'id' => $id ) )->result();
		if ( !isset($media[0]) ) return false;

		$user = $this->session->userdata( 'user' );
		if ( empty($user) ) return null;
		$this->Activitymodel->add( $user->id, 
			'Delete media ('. $media[0]->title .' - '. $media[0]->file_name .')',
			site_url( 'media' ) );

		$app_path = BASEPATH .'../..';

		if ( !empty($media[0]->image) )
			@unlink($app_path . $media[0]->image );
		if ( !empty($media[0]->image_920) )
			@unlink($app_path . $media[0]->image_920 );
		if ( !empty($media[0]->image_270) )
			@unlink($app_path . $media[0]->image_270 );
		if ( !empty($media[0]->image_90) )
			@unlink($app_path . $media[0]->image_90 );

		$this->db->delete('media', Array( 'id' => $id ));

		return true;
	}
}