<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			exit();
		}
	}

	public function display(){
		$this->db->limit(1);
		$data = $this->db->get( 'setting_display' )->result();
		if ( !isset($data[0]) ){
			$this->db->insert( 'setting_display', Array( 'display_quote' => '1' ) );
			$this->db->limit(1);
			$data = $this->db->get( 'setting_display' )->result();
		}

		$data = $data[0];

		$hData = Array( 'css' => Array(
			site_url('resources/vendors/switchery/dist/switchery.min.css') ));
		$vData = Array( 'setting' => $data );
		$fData = Array( 'js' => Array(
			site_url('resources/vendors/switchery/dist/switchery.min.js') ));

		$this->load->view('static/head', $hData);
		$this->load->view('setting/display', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function content(){

		$this->db->limit(1);
		$data = $this->db->get( 'setting_content' )->result();
		if ( !isset($data[0]) ){
			$this->db->insert( 'setting_content', Array( 
				'comment_by' 				=> 'disqus',
				'display_comment_in_desa'	=> 0,
				'display_comment_in_news'	=> 1,
				'autoload_next_news'		=> 0,
				'display_related_news'		=> 1,
				'display_event'				=> 1,
				'display_news'				=> 1 ));
			$this->db->limit(1);
			$data = $this->db->get( 'setting_content' )->result();
		}

		$data = $data[0];

		$hData = Array( 'css' => Array(
			site_url('resources/vendors/switchery/dist/switchery.min.css') ));
		$vData = Array( 'setting' => $data );
		$fData = Array( 'js' => Array(
			site_url('resources/vendors/switchery/dist/switchery.min.js') ));

		$this->load->view('static/head', $hData);
		$this->load->view('setting/content', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function web(){
		$this->db->limit(1);
		$data = $this->db->get( 'setting' )->result();
		if ( !isset($data[0]) ){
			$this->db->insert( 'setting', Array( 'site_name' => 'Hutanpapua' ) );
			$this->db->limit(1);
			$data = $this->db->get( 'setting' )->result();
		}

		$data = $data[0];

		$vData = Array( 'setting' => $data );
		$fData = Array( 'js' => Array() );

		$this->load->view('static/head');
		$this->load->view('setting/web', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function save( $setting ){

		$data = $this->input->post();
		switch ($setting) {
			case 'web':
				$dbData = Array(
					'site_name'			=> $data['site_name'],
					'site_description'	=> $data['site_description'],
					'google_webmaster'	=> $data['google_webmaster'],
					'google_analityc'	=> $data['google_analityc'],
					'bing_webmaster'	=> $data['bing_webmaster'],
					'facebook_url'		=> $data['facebook_url'],
					'twitter_url'		=> $data['twitter_url'],
					'youtube_url'		=> $data['youtube_url'],
					'instagram_url'		=> $data['instagram_url'] );

				$this->db->update( 'setting', $dbData );

				$user = $this->session->userdata( 'user' );
				$this->Activitymodel->add( $user->id, 
					'Update web setting.',
					site_url( 'setting/web' ) );

				echo json_encode(Array( 'status' => 200 ));
				break;

			case 'display':
				$display_article_1 = (!empty($data['display_article_1'])) ? 1 : 0;
				$display_article_2 = (!empty($data['display_article_2'])) ? 1 : 0;
				$display_article_3 = (!empty($data['display_article_3'])) ? 1 : 0;
				$dbData = Array(
						'display_article_1'	=> $display_article_1,
						'display_article_2'	=> $display_article_2,
						'display_article_3'	=> $display_article_3 );

				$this->db->update( 'setting_display', $dbData );

				$user = $this->session->userdata( 'user' );
				$this->Activitymodel->add( $user->id, 
					'Update display setting.',
					site_url( 'setting/display' ) );

				echo json_encode(Array( 'status' => 200 ));
				break;

			case 'content':
				$dbData = Array(
					'comment_by' 				=> $data['comment_by'],
					'display_comment_in_desa'	=> (!empty($data['display_comment_in_desa'])),
					'display_comment_in_news'	=> (!empty($data['display_comment_in_news'])),
					'autoload_next_news'		=> (!empty($data['autoload_next_news'])),
					'display_related_news'		=> (!empty($data['display_related_news'])),
					'display_event'				=> (!empty($data['display_event'])),
					'display_news'				=> (!empty($data['display_news'])) );

				$this->db->update( 'setting_content', $dbData );

				$user = $this->session->userdata( 'user' );
				$this->Activitymodel->add( $user->id, 
					'Update content setting.',
					site_url( 'setting/content' ) );

				echo json_encode(Array( 'status' => 200 ));
				break;
			
			default:
				# code...
				break;
		}
	}
}
