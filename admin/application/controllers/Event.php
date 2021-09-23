<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			exit();
		}
	}

	public function index(){
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			return;
		}

		$this->db->limit(12);
		$data = $this->db->get( 'events' )->result();

		$hData = Array(
			'title'	=> 'Semua Acara',
			'css'	=> 	Array(
						site_url('resources/vendors/fullcalendar/dist/fullcalendar.min.css') ));
		$vData = Array( 'data' 	=> $data, '__meta' => $data );
		$fData = Array( 'js'	=> Array( 
						site_url('resources/vendors/moment/min/moment.min.js'),
						site_url('resources/vendors/fullcalendar/dist/fullcalendar.min.js'),
						site_url('resources/js/event.js') ));


		$this->load->view('static/head', $hData);
		$this->load->view('event/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function add( $id = 0 ){
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			return;
		}

		$this->load->model('Postmodel');

		$vData = Array();
		$vData['trips'] = $this->Postmodel->getSimple( Array( 'parent' => 'trips', 'is_publish' => 1));

		if ( !empty($id) ){
			$data = $this->db->get_where( 'events', Array( 'id' => $id ) )->result();
			if (empty($data)){
				$this->load->view('errors/html/error_404');
				return;
			}
			if ( !empty($data[0]->poster) ){
				$poster = $this->db->get_where('media', Array( 'id' => $data[0]->poster ))->result();
				$data[0]->poster_data = $poster[0];
			}

			$vData['data'] = $data[0];
		}
		$this->load->view('event/add', $vData);
	}

	public function edit($id){
		$this->add($id);
	}

	public function feed(){
		$start 	= strtotime($this->input->get('start'));
		$end 	= strtotime($this->input->get('end'));
		$this->db->where( 'event_date >=', $start );
		$this->db->where( 'end_date <=', $end );
		$data 	= $this->db->get( 'events' )->result();
		$events = Array();
		foreach ($data as $key => $value) {

			$allDay = $value->end_date - $value->event_date;
			$allDay /= 86400;
			$allDay = (!is_float($allDay)) ? true : false;

			$events[] = Array(
				'id' 	 =>	$value->id,
				'title'	 => $value->name,
				'start'  => date('c', $value->event_date),
				'end'    => date('c', $value->end_date),
				'allDay' => $allDay );
		}

		echo json_encode($events);
	}

	public function changedate( $id ){
		$data = $this->input->post();
		$event = $this->db->get_where( 'events', Array( 'id' => $id ) )->result();
		if ( empty($event) ){
			echo json_encode(Array( 'status' => 404, 'message' => 'Event data not found.' ));
			return;
		}

		$dbData = Array();
		// 25200 = 7 hour
		$data['start'] = $data['start'] - 25200;
		$data['end']   = $data['end'] - 25200;

		// 86400 == 24 hour
		$allDay = (($data['end'] - $data['start']) == 86400)? 1: 0;

		$dbData['event_date']	= $data['start'];
		$dbData['event_day']	= date('j', $data['start']);
		$dbData['event_month']	= date('n', $data['start']);
		$dbData['event_year']	= date('Y', $data['start']);
		$dbData['event_hour']	= date('G', $data['start']);
		$dbData['event_minute']	= date('i', $data['start']);
		$dbData['event_second']	= date('s', $data['start']);
		$dbData['end_date']		= $data['end'];
		$dbData['end_day']		= date('j', $data['end']);
		$dbData['end_month']	= date('n', $data['end']);
		$dbData['end_year']		= date('Y', $data['end']);
		$dbData['end_hour']		= date('G', $data['end']);
		$dbData['end_minute']	= date('i', $data['end']);
		$dbData['end_second'] 	= date('s', $data['end']);
		$dbData['all_day']		= $allDay;

		// Insert activity
		$user = $this->session->userdata('user');
		$activity_message = 'Change date of event ('. $event[0]->name .')';
		$this->Activitymodel->add( $user->id, 
			$activity_message,
			site_url( 'event' ) );

		$this->db->update( 'events', $dbData, Array( 'id' => $id ) );
		echo json_encode(Array( 'status' => 200 ));
	}


	private function _genSlug( $title = null, $id = 0 ){

		if ( $title == null )
			$slug 	= 'hutanpapua-acara';
		else
			$slug 	= strtolower(preg_replace('/[ ]|[^a-zA-Z0-9]/', '-', $title));

		if ( !empty($id) ) 
			$this->db->where( 'id !=', $id );
		$this->db->where( 'slug', $slug );
		$x_data  	= $this->db->get('events')->num_rows();
		if ( $x_data > 0 ){
			$slug 	= $slug .'-'. $x_data;
			return $this->_genSlug( $slug );
		}
		return $this->_removeSlugStripe( $slug );
	}

	private function _removeSlugStripe( $slug ){
		$slug = str_replace('--', '-', $slug);
		if ( strstr($slug, '--') )
			return $this->_removeSlugStripe( $slug );
		return $slug;
	}

	public function save(){

		$this->load->model('Postmodel');

		$data = $this->input->post();
		$user = $this->session->userdata('user');

		$trip = $this->Postmodel->getSimple(Array( 'id' => $data['trip'] ));
		$data['name'] = $trip[0]->title;

		$slug = (!empty($data['edit_id'])) 
			? $this->_genSlug($data['name'], $data['edit_id']) 
			: $this->_genSlug($data['name']);
		$dbData = Array(
			'slug'			=> $slug,
			'name'			=> $data['name'],
			'description' 	=> $data['description'],
			'location' 		=> '',
			'url'			=> '',
			'poster'		=> '' );

		$dbData['post_id'] = $data['trip'];

		if ( empty($data['edit_id']) )
			$dbData['created_date'] = time();

		if ( !empty($data['event_start']) and !empty($data['event_end']) ){
			// 25200 = 7 hour
			// $data['event_start'] = $data['event_start'] - 25200;
			// $data['event_end']   = $data['event_end'] - 25200;

			// 86400 == 24 hour
			$allDay = (($data['event_end'] - $data['event_start']) == 86400)? 1: 0;

			$dbData['event_date']	= $data['event_start'];
			$dbData['event_day']	= date('j', $data['event_start']);
			$dbData['event_month']	= date('n', $data['event_start']);
			$dbData['event_year']	= date('Y', $data['event_start']);
			$dbData['event_hour']	= date('G', $data['event_start']);
			$dbData['event_minute']	= date('i', $data['event_start']);
			$dbData['event_second']	= date('s', $data['event_start']);
			$dbData['end_date']		= $data['event_end'];
			$dbData['end_day']		= date('j', $data['event_end']);
			$dbData['end_month']	= date('n', $data['event_end']);
			$dbData['end_year']		= date('Y', $data['event_end']);
			$dbData['end_hour']		= date('G', $data['event_end']);
			$dbData['end_minute']	= date('i', $data['event_end']);
			$dbData['end_second'] 	= date('s', $data['event_end']);
			$dbData['all_day']		= $allDay;
		}

		if ( empty($data['edit_id']) ){

			// Insert activity
			$activity_message = 'Add new event ('. $dbData['name'] .')';
			$this->Activitymodel->add( $user->id, 
				$activity_message,
				site_url( 'event' ) );

			$this->db->insert( 'events', $dbData );
			$dbData['id'] = $this->db->insert_id();
		} else {

			// Insert activity
			$activity_message = 'Edit event ('. $dbData['name'] .')';
			$this->Activitymodel->add( $user->id, 
				$activity_message,
				site_url( 'event' ) );

			$this->db->update( 'events', $dbData, Array( 'id' => $data['edit_id'] ) );
			$dbData['id'] = $data['edit_id'];
		}

		echo json_encode(Array( 'status' => 200, 'event' => $dbData ));
	}

	public function delete($id){
		$this->db->delete('events', Array('id' => $id));
	}
}