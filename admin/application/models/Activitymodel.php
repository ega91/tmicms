<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activitymodel extends CI_Model {

	public function add( $user_id, $activity, $url = null ){
		$dbData = Array(
			'user_id'	=> $user_id,
			'activity'	=> $activity,
			'url'		=> $url,
			'timestamp'	=> time(),
			'date_day'	=> date('j'),
			'date_month' => date('n'),
			'date_year'	=> date('Y') );

		$this->db->limit(1);
		$this->db->order_by('id', 'desc');
		$lastData = $this->db->get( 'activity' )->result();
		if ( isset($lastData[0]) 
			and $lastData[0]->user_id == $dbData['user_id']
			and $lastData[0]->activity == $dbData['activity'] ){}
		else {
			$this->db->insert( 'activity', $dbData );
		}
	}

	public function get( $params = array() ){
		$limit = (!empty($params['limit'])) ? $params['limit'] : 16;
		$this->db->limit($limit);
		$this->db->order_by('id', 'desc');
		$data = $this->db->get('activity')->result();
		foreach ($data as $key => $value) {
			if ( empty($value->user_id) ){
				unset($data[$key]);
			} else {
				$user = $this->db->get_where( 'users', Array( 'id' => $value->user_id ) )->result();
				$data[$key]->user = $user[0];
			}
		}

		return $data;
	}
}

