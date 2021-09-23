<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postmodel extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	private function _genSlug( $title = null, $id = 0 ){

		if ( $title == null ){
			$slug 	= 'post-private-preview';
		} else{
			$slug 	= strtolower(preg_replace('/[ ]|[^a-zA-Z0-9]/', '-', $title));
			$slug 	= $this->_removeSlugStripe( $slug );
		}

		if ( !empty($id) ) 
			$this->db->where( 'id !=', $id );
		$this->db->where( 'slug', $slug );
		$x_data = $this->db->get('post')->num_rows();
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

	public function save( $data ){
		$user = $this->session->userdata('user');

		if ( empty($data['parent']) ){
			return Array( 'status' => 400, 'message' => 'Post parent ID required.' );
		}
		if ( empty($data['cat']) ) $data['cat'] = Array(1);

		if ( !empty($data['id']) ){

			$post_id = $data['id'];

			$publish_date = $data['date'] .' '. $data['time'];
			$publish_date = strtotime($publish_date);

			$dbData = Array(
				'tags'				=> $data['tags'],
				'featured_image'	=> $data['featured_image'],
				'last_edited_by'	=> $user->id,
				'publish_date'		=> $publish_date,
				'last_edited_date'	=> time(),
				'last_edited_ip'	=> $this->input->ip_address(),
				'slug'				=> $this->_genSlug( $data['title'], $post_id ),
				'is_publish'		=> $data['is_publish'],
				'featured'			=> 0,
				'title'				=> $data['title'],
				'lang'				=> $data['lang'],
				'description'		=> '',
				'display_author'	=> ($data['display_author'] == 'true'),
				'allow_comment'		=> ($data['allow_comment'] == 'true') 
			);

			if ( empty($dbData['lang']) ) $dbData['lang'] = 'en';

			$this->db->update('post', $dbData, Array( 'id' => $post_id ));

			$this->db->delete('post_category_helper', Array( 'post_id' => $post_id ));
			if ( empty($data['cat']) ){
				$uncategorized = $this->db->get_where('post_category', Array( 'post_parent' => 0 ))->result();
				if ( isset($uncategorized[0]) )
					$this->db->insert('post_category_helper', Array( 'post_id' => $post_id, 'cat_id' => $uncategorized[0]->id ));
			} else {
				foreach ($data['cat'] as $cat) {
					$this->db->insert('post_category_helper', Array( 'post_id' => $post_id, 'cat_id' => $cat ));
				}
			}

			// Update content
			$this->db->update('post_content', Array( 'content' => trim($data['content']) ), Array( 'post_id' => $post_id ));

			$description = strip_tags($data['content']);
			if ( !empty($description) ){
				$description = substr(str_replace('  ', ' ', trim($description)), 0, 240);
				$this->db->update('post', Array( 'description' => $description ), Array( 'id' => $post_id ));
			}

			$parent = $this->db->get_where('post_parent', Array( 'id' => $data['parent'] ))->result();
			if ( $parent[0]->slug == 'trips' ){
				$this->db->delete('trip_images', Array( 'post_id' => $post_id ));
				if ( !empty($data['images']) ){ foreach ($data['images'] as $key => $value) {
					$this->db->insert('trip_images', Array( 
						'post_id' 	=> $post_id,
						'media_id'	=> $value['id'],
						'active'	=> ($value['active'] == 'true') ));

					if ( $value['active'] == 'true' )
						$this->db->update('post', Array( 'featured_image' => $value['id'] ), Array( 'id' => $post_id ));
				}}

				if ( $this->db->get_where('trip_data', Array( 'post_id' => $post_id ))->num_rows() <= 0 ){
					$this->db->insert('trip_data', Array( 'post_id' => $post_id ));
				}

				$this->db->update('trip_data', Array( 
					'price'		=> $data['price'],
					'person'	=> $data['price_person'] ), 
				Array(
					'post_id'	=> $post_id ));
			}

			return Array( 'status' => 200, 'edit_id' => $post_id );

		} else {

			$publish_date = $data['date'] .' '. $data['time'];
			$publish_date = strtotime($publish_date);

			$dbData = Array(
				'tags'				=> $data['tags'],
				'featured_image'	=> $data['featured_image'],
				'author'			=> $user->id,
				'last_edited_by'	=> $user->id,
				'publish_date'		=> $publish_date,
				'created_date'		=> time(),
				'last_edited_date'	=> time(),
				'last_edited_ip'	=> $this->input->ip_address(),
				'slug'				=> $this->_genSlug( $data['title'] ),
				'is_publish'		=> $data['is_publish'],
				'post_parent'		=> $data['parent'],
				'featured'			=> 0,
				'view_count'		=> 0,
				'title'				=> $data['title'],
				'lang'				=> $data['lang'],
				'description'		=> '',
				'display_author'	=> ($data['display_author'] == 'true'),
				'allow_comment'		=> ($data['allow_comment'] == 'true') 
			);

			if ( empty($dbData['lang']) ) $dbData['lang'] = 'en';

			$this->db->insert('post', $dbData);
			$post_id = $this->db->insert_id();

			foreach ($data['cat'] as $cat) {
				$this->db->delete('post_category_helper', Array( 'post_id' => $post_id ));
				$this->db->insert('post_category_helper', Array( 'post_id' => $post_id, 'cat_id' => $cat ));
			}

			// Update content
			$this->db->insert('post_content', Array( 'post_id' => $post_id, 'content' => trim($data['content']) ));

			$description = strip_tags($data['content']);
			if ( !empty($description) ){
				$description = substr(str_replace('  ', ' ', trim($description)), 0, 240);
				$this->db->update('post', Array( 'description' => $description ), Array( 'id' => $post_id ));
			}

			$parent = $this->db->get_where('post_parent', Array( 'id' => $data['parent'] ))->result();
			if ( $parent[0]->slug == 'trips' ){
				if ( !empty($data['images']) ){ foreach ($data['images'] as $key => $value) {
					$this->db->insert('trip_images', Array( 
						'post_id' 	=> $post_id,
						'media_id'	=> $value['id'],
						'active'	=> ($value['active'] == 'true') ));

					if ( $value['active'] == 'true' )
						$this->db->update('post', Array( 'featured_image' => $value['id'] ), Array( 'id' => $post_id ));
				}}

				$this->db->insert('trip_data', Array( 
					'price'		=> $data['price'],
					'person'	=> $data['price_person'],
					'post_id'	=> $post_id ));
			}

			return Array( 'status' => 200, 'edit_id' => $post_id );
		}
	}

	public function publish( $id ){
		$user = $this->session->userdata('user');
		$data = $this->db->get_where( 'post', Array( 'id' => $id ) )->result();
		if ( empty($data) ) return Array( 'status' => 300, 'message' => 'Content not found.' );
		$data = $data[0];
		$parent = $this->db->get_where('post_parent', Array( 'id' => $data->post_parent ))->result();
		$parent = $parent[0];
		$this->db->order_by('order_number');
		$this->db->limit(1);
		$sections = $this->db->get_where( 'post_section', Array( 'post_id' => $id ) )->result();

		$activity_message = 'Publish '. $parent->name;
		if ( !empty($sections[0]->title) )
			$activity_message .= ' ('. $sections[0]->title .')';
		$this->Activitymodel->add( $user->id, 
			$activity_message,
			site_url( $parent->slug ) );

		$dbData = Array( 'is_publish' => 1, 'status' => 'published' );

		$this->db->select('id');
		$is_publish = ( $this->db->get_where( 'post', Array( 'id' => $id, 'is_publish' => 1 ))->num_rows() > 0 );
		if ( !$is_publish )
			$dbData['published_date'] = time();


		$this->db->update( 'post', $dbData, Array( 'id' => $id ) );
		return Array( 'status' => 200 );
	}

	public function setfeatured( $id ){
		$this->db->update( 'post', Array( 'featured' => 1 ), Array( 'id' => $id ) );
		return Array( 'status' => 200 );
	}

	public function unsetfeatured( $id ){
		$this->db->update( 'post', Array( 'featured' => 0 ), Array( 'id' => $id ) );
		return Array( 'status' => 200 );
	}

	public function get( $params = array() ){

		if ( !empty($params['parent']) ){
			if ( is_string($params['parent']) ){
				$params['parent'] = $this->db->get_where( 'post_parent', Array( 'slug' => $params['parent'] ))->result();
				if ( empty($params['parent']) ){
					return null;
				}
				$params['parent'] = $params['parent'][0]->id;
			}
			$this->db->where( 'post_parent', $params['parent'] );
		}

		if ( isset($params['id']) )
			$this->db->where( 'id', $params['id'] );
		if ( isset($params['id !=']) )
			$this->db->where( 'id !=', $params['id !='] );
		if ( isset($params['slug']) )
			$this->db->where( 'slug', $params['slug'] );
		if ( isset($params['is_publish']) )
			$this->db->where( 'is_publish', $params['is_publish'] );
		if ( isset($params['featured']) )
			$this->db->where( 'featured', $params['featured'] );
		if ( isset($params['lang']) )
			$this->db->where( 'lang', $params['lang'] );


		$order = (isset($params['order'])) ? $params['order'] : 'id';
		$order_type = (isset($params['order_type'])) ? $params['order_type'] : 'desc';
		$this->db->order_by($order, $order_type);

		if ( isset($params['limit']) )
			$this->db->limit($params['limit']);
		$dataAll = $this->db->get( 'post' )->result();
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

			// Featured image
			if ( !empty($data->featured_image) ){
				$featured_image = $this->db->get_where( 'media', Array( 'id' => $data->featured_image ) )->result();
				if ( !empty($featured_image) )
					$dataAll[ $key_data ]->featured_image = $featured_image[0];
			}

			$post_parent = $this->db->get_where( 'post_parent', Array( 'id' => $data->post_parent ) )->result();
			$dataAll[ $key_data ]->parent = $post_parent[0];

			if ( $post_parent[0]->slug == 'trips' ){
				$dataAll[ $key_data ]->images = $this->db->get_where('trip_images', Array( 'post_id' => $data->id ))->result();
				foreach ($dataAll[ $key_data ]->images as $keyImg => $image) {
					$_image = $this->db->get_where('media', Array( 'id' => $image->media_id ))->result();
					if ( empty($_image) ){
						unset($dataAll[ $key_data ]->images[ $keyImg ]);
						continue;
					}

					$_image[0]->active = $image->active;
					$dataAll[ $key_data ]->images[ $keyImg ] = $_image[0];
					if ( !empty($image->active) ){
						$dataAll[ $key_data ]->image_active = $_image[0];
					}
				}
				$trip_data = $this->db->get_where('trip_data', Array( 'post_id' => $data->id ))->result();
				$dataAll[ $key_data ]->trip_data = $trip_data[0];
			}

			// Categories
			$this->db->select('post_category.*');
			$this->db->join('post_category_helper', 'post_category_helper.cat_id =  post_category.id', 'left');
			$this->db->where('post_id', $data->id);
			$dataAll[ $key_data ]->categories = $this->db->get('post_category')->result();

			/**
			 * Content
			 *
			 */
			if ( !isset($params['content']) or $params['content'] == true ){
				$this->db->where( 'post_id', $data->id );
				$content = $this->db->get( 'post_content' )->result();
				$dataAll[ $key_data ]->content = $content[0]->content;
			}
		}

		return $dataAll;
	}

	public function getCategories($parentID){
		$this->db->where('post_parent', 0);
		$this->db->or_where('post_parent', $parentID);
		return $this->db->get('post_category')->result();
	}

	public function deleteCategory($id){
		$data = $this->db->get_where( 'post_category', Array( 'id' => $id ) )->result();
		if ( empty($data) )
			return Array( 'status' => 200 );
		$data = $data[0];

		// Delete category helper
		$this->db->delete( 'post_category_helper', Array( 'cat_id' => $data->id ) );

		// Delete the category
		$this->db->delete( 'post_category', Array( 'id' => $data->id ) );

		return Array( 'status' => 200 );
	}

	public function getSimple( $params = array() ){
		$params['content'] = false;
		return $this->get( $params );
	}

	public function getParentBySlug( $slug ){
		$data = $this->db->get_where( 'post_parent', Array( 'slug' => $slug ))->result();
		if ( empty($data) ) return null;
		return $data[0];
	}

	public function getParent( $id ){
		$parent = $this->db->get_where( 'post', Array( 'id' => $id ))->result();
		if ( empty($parent) ) return null;
		$data = $this->db->get_where( 'post_parent', Array( 'id' => $parent[0]->post_parent ))->result();
		if ( empty($data) ) return null;
		return $data[0];
	}

	public function delete( $id ){
		$data = $this->db->get_where( 'post', Array( 'id' => $id ) )->result();
		if ( empty($data) )
			return Array( 'status' => 200 );
		$data = $data[0];

		// Delete contents
		$this->db->delete( 'post_content', Array( 'post_id' => $data->id ) );

		// All contents deleted, now delete the post
		$this->db->delete( 'post', Array( 'id' => $data->id ) );

		return Array( 'status' => 200 );
	}
}