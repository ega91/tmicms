<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index(){

		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			return;
		} else {
			header('Location: '. site_url('messages'));
			return;
		}

		$vData = Array();

		$hData = Array(
			'title'	=> 'Dashboard',
			'css'	=> Array() );
		$fData = Array(
			'js'	=> Array() );

		$this->load->view('static/head', $hData);
		$this->load->view('welcome', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function activity(){
		$_6d = strtotime( date('Y-m-d', strtotime('-6 days')) .'T00:00:00+07:00' );
		$_5d = strtotime( date('Y-m-d', strtotime('-5 days')) .'T00:00:00+07:00' );
		$_4d = strtotime( date('Y-m-d', strtotime('-4 days')) .'T00:00:00+07:00' );
		$_3d = strtotime( date('Y-m-d', strtotime('-3 days')) .'T00:00:00+07:00' );
		$_2d = strtotime( date('Y-m-d', strtotime('-2 days')) .'T00:00:00+07:00' );
		$_1d = strtotime( date('Y-m-d', strtotime('-1 day')) .'T00:00:00+07:00' );
		$_today = strtotime( date('Y-m-d') .'T00:00:00+07:00' );

		$activityChart = Array(
			date('l', $_6d) => $this->db->get_where( 'activity', 
				Array( 'timestamp >=' => $_6d, 'timestamp <' => $_5d ))->num_rows(),
			date('l', $_5d) => $this->db->get_where( 'activity', 
				Array( 'timestamp >=' => $_5d, 'timestamp <' => $_4d ))->num_rows(),
			date('l', $_4d) => $this->db->get_where( 'activity', 
				Array( 'timestamp >=' => $_4d, 'timestamp <' => $_3d ))->num_rows(),
			date('l', $_3d) => $this->db->get_where( 'activity', 
				Array( 'timestamp >=' => $_3d, 'timestamp <' => $_2d ))->num_rows(),
			date('l', $_2d) => $this->db->get_where( 'activity', 
				Array( 'timestamp >=' => $_2d, 'timestamp <' => $_1d ))->num_rows(),
			date('l', $_1d) => $this->db->get_where( 'activity', 
				Array( 'timestamp >=' => $_1d, 'timestamp <' => $_today ))->num_rows(),
			'Today' => $this->db->get_where( 'activity', 
				Array( 'timestamp >=' => $_today ))->num_rows()
		);

		$max = 0;
		foreach ($activityChart as $key => $value) {
			if ( $value > $max )
				$max = $value;
		}

		$this->load->view( 'welcome/activity', Array( 'max' => $max, 'data' => $activityChart ) );
	}

	public function events(){
		$_1m = strtotime( date('Y-m-d', strtotime('-1 month')) .'T00:00:00+07:00' );
		$events = $this->db->get_where('events', Array( 'event_date >=' => $_1m ))->result();
		foreach ($events as $key => $value) {
			$media = $this->db->get_where( 'media', Array( 'id' => $value->poster ) )->result();
			if ( !empty($media) )
				$events[$key]->poster = $media[0];
		}

		$this->load->view( 'welcome/events', Array( 'data' => $events ) );
	}
}
