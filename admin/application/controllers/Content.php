<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH .'vendor/autoload.php';

class Content extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if ( $this->session->userdata('logged_in') != true ){
			header('Location: '. site_url('user/login'));
			exit();
		}
	}

	public function allclaim(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'claims?key='. API_KEY .'&secret='. $user->secret .'&'. http_build_query($params));

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('claim/content', $vData);
	}

	public function claim($page = 'all'){

		$user = $this->session->userdata('user');
		if ($user->role_data->view_claim < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Semua Pengajuan Klaim' );
		$vData = Array( 'page' => $page );
		$fData = Array( 'js' => Array() );

		switch ($page) {
			case 'aproved': $hData['title'] = 'Klaim Disetujui'; break;
			case 'declined': $hData['title'] = 'Klaim Ditolak'; break;
			case 'waiting': $hData['title'] = 'Menunggu Persetujuan'; break;
			default: break;
		}

		$this->load->view('static/head', $hData);
		$this->load->view('claim/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function claimdetail($id){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_claim < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Detil Klaim' );
		$vData = Array( 'data' => null );
		$fData = Array( 'js' => Array() );

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'claim/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$vData = Array( 'data' => $data );

		if ($this->input->get('print') == 'data'){
			$this->load->view('static/print_header', $hData);
			$this->load->view('claim/detail_content', $vData);
			$this->load->view('static/print_footer', $fData);
			return;
		}

		$this->load->view('static/head', $hData);
		$this->load->view('claim/detail', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function approveclaim($id){
		$user = $this->session->userdata('user');
		$message = $this->input->post('message');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'claim/'. $id .'/approve?key='. API_KEY .'&secret='. $user->secret, Array(
			'form_params'	=> Array(
				'message'	=> $message
			)
		));

		if ( $res->getStatusCode() != 200 ){
			echo json_decode(Array( 'status' => 500, 'message' => 'Tidak dapat terhubung ke server' ));
		} else {
			echo $res->getBody();
		}
	}

	public function rejectclaim($id){
		$user = $this->session->userdata('user');
		$message = $this->input->post('message');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'claim/'. $id .'/reject?key='. API_KEY .'&secret='. $user->secret, Array(
			'form_params'	=> Array(
				'message'	=> $message
			)
		));

		if ( $res->getStatusCode() != 200 ){
			echo json_decode(Array( 'status' => 500, 'message' => 'Tidak dapat terhubung ke server' ));
		} else {
			echo $res->getBody();
		}
	}

	private function arrayToCsv( stdClass &$fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
	    $delimiter_esc = preg_quote($delimiter, '/');
	    $enclosure_esc = preg_quote($enclosure, '/');

	    $output = array();
	    foreach ( $fields as $field ) {
	        if ($field === null && $nullToMysqlNull) {
	            $output[] = 'NULL';
	            continue;
	        }

	        // Enclose fields containing $delimiter, $enclosure or whitespace
	        if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
	            $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
	        }
	        else {
	            $output[] = $field;
	        }
	    }

	    return implode( $delimiter, $output );
	}

	private function exportTrx($exportType){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'transactions?key='. API_KEY .'&secret='. $user->secret .'&'. http_build_query($params));

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$csvHeader = new stdClass();
		$csvHeader->a = 'Transaction No';
		$csvHeader->b = 'Invoice No';
		$csvHeader->c = 'User';
		$csvHeader->d = 'User Email';
		$csvHeader->e = 'User Phone';
		$csvHeader->f = 'Payment Method';
		$csvHeader->g = 'Bank';
		$csvHeader->h = 'Virtual Account No';
		$csvHeader->i = 'Voucher Code';
		$csvHeader->j = 'Subtotal';
		$csvHeader->k = 'Discount';
		$csvHeader->l = 'Discount Ammount';
		$csvHeader->m = 'Grand Total';
		$csvHeader->n = 'Date';

		$csv  = $this->arrayToCsv($csvHeader);
		$csv .= "\r\n";

		foreach ($data as $key => $value) {
			$_tmp = new stdClass();
			$_tmp->a = $value->trx_no;
			$_tmp->b = $value->invoice_no;
			$_tmp->c = $value->user->full_name;
			$_tmp->d = $value->user->email;
			$_tmp->e = $value->user->phone;
			$_tmp->f = ucwords(str_replace('_', ' ', $value->payment_method));
			$_tmp->g = (!empty($value->bank)) ? $value->bank->nama_bank : '';
			$_tmp->h = $value->trx_no;
			$_tmp->i = $value->voucher_code;
			$_tmp->j = $value->total_price;
			$_tmp->k = $value->discount;
			$_tmp->l = $value->discount_ammount;
			$_tmp->m = $value->grand_total;
			$_tmp->n = date('Y-m-d H:i:s', $value->trx_timestamp);
			$csv .= $this->arrayToCsv($_tmp);
			$csv .= "\r\n";
		}

	    header("Content-type: text/csv");
	    header("Content-Disposition: attachment; filename=transactions.csv");
	    header("Pragma: no-cache");
	    header("Expires: 0");

	    echo "\"sep=,\"\n";
		echo $csv;
		return;
	}

	public function alltrx(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		if (!empty($params['export']) && $params['export'] == 'csv'){
			return $this->exportTrx('csv');
		}

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'transactions?key='. API_KEY .'&secret='. $user->secret .'&'. http_build_query($params));

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('transaction/content', $vData);
	}

	public function filtertrx(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'products?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = $this->input->get();
		$vData['product'] = $data;

		$this->load->view('transaction/filter', $vData);
	}

	public function transactions($page = 'all'){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_trx < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$_page = $page;
		if ($page == 'success') $_page = 'paid';
		elseif ($page == 'waiting') $_page = 'waiting_payment';

 		$hData = Array(
 			'title'	=> 'Semua Transaksi' );
		$vData = Array( 'data' => null, 'page' => $_page );
		$fData = Array( 'js' => Array() );

		switch ($page) {
			case 'failed': $hData['title'] = 'Transaksi Gagal'; break;
			case 'waiting': $hData['title'] = 'Menunggu Pembayaran'; break;
			default: break;
		}

		$this->load->view('static/head', $hData);
		$this->load->view('transaction/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function allbuyrq(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'berminat?key='. API_KEY .'&secret='. $user->secret .'&'. http_build_query($params));

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('buyrequest/content', $vData);
	}

	public function filterberminat(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'products?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = $this->input->get();
		$vData['product'] = $data;

		$this->load->view('buyrequest/filter', $vData);
	}

	public function filterclaim(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'products?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = $this->input->get();
		$vData['product'] = $data;

		$this->load->view('claim/filter', $vData);
	}

	public function buyrequest(){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_berminat < 1){
			header('Location: /error/404');
			return;
		}


		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Semua Berminat' );
		$vData = Array( 'data' => null );
		$fData = Array( 'js' => Array() );

		$this->load->view('static/head', $hData);
		$this->load->view('buyrequest/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function followupberminat($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$note = $this->input->post('note');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'berminat/'. $id .'/followup?key='. API_KEY .'&secret='. $user->secret, Array(
			'form_params'	=> Array(
				'note' 		=> $note
			)
		));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array('status' => 500));
		} else {
			echo $res->getBody();
		}
	}

	public function cancelfollowupberminat($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'berminat/'. $id .'/cancelfollowup?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array('status' => 500));
		} else {
			echo $res->getBody();
		}
	}

	public function polis($page = 'all'){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_polis < 1){
			header('Location: /error/404');
			return;
		}


		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'All Polis' );
		$vData = Array( 'page' => $page );
		$fData = Array( 'js' => Array() );

		switch ($page) {
			case 'sudah_berakhir': $hData['title'] = 'Polis Sudah Berakhir'; break;
			case 'pending': $hData['title'] = 'Menunggu Pembayaran'; break;
			case 'aktif': $hData['title'] = 'Polis Aktif'; break;
			default: break;
		}

		$this->load->view('static/head', $hData);
		$this->load->view('polis/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function polisdetail($id){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_polis < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Detil Polis' );
		$vData = Array( 'data' => null );
		$fData = Array( 'js' => Array() );

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'polis/'. $id .'/am_detail?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$vData = Array( 'data' => $data );

		if ($this->input->get('print') == 'data'){
			$this->load->view('static/print_header', $hData);
			$this->load->view('polis/content_detail', $vData);
			$this->load->view('static/print_footer', $fData);
			return;
		}

		$this->load->view('static/head', $hData);
		$this->load->view('polis/detail', $vData);
		$this->load->view('static/footer', $fData);
	}

	private function exportPolis($exportType){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$params['export'] = 1;
		$queryParams = http_build_query($params);
		$uri    = API_URI .'polis/all?key='. API_KEY .'&secret='. $user->secret;
		$uri   .= (!empty($params)) ? '&'. $queryParams : '';
		$vData = Array();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', $uri);

		if ( $res->getStatusCode() != 200 ){
			$vData['data'] = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $vData['data'] = $data->results;
			else $vData['data'] = null;

			if ( !empty($data->next) ){
				$nextParams = $params;
				$nextParams['page'] = (!empty($nextParams['page'])) ? ($nextParams['page'] + 1) : 1;
				$vData['next'] = site_url('content/allpolis?'. http_build_query($nextParams));
			}

			if ( !empty($data->prev) ){
				$prevParams = $params;
				$prevParams['page'] = (!empty($prevParams['page'])) ? ($prevParams['page'] - 1) : 0;
				$vData['prev'] = site_url('content/allpolis?'. http_build_query($prevParams));
			}
		}

		$data = $vData['data'];
		if (empty($data)) $data = Array();

		$csvHeader = new stdClass();
		$csvHeader->a = 'No';
		$csvHeader->b = 'No Polis';
		$csvHeader->c = 'No Transaksi';
		$csvHeader->d = 'No Invoice';
		$csvHeader->e = 'Status';
		$csvHeader->f = 'Pemegang Polis';
		$csvHeader->i = 'Tertanggung';
		$csvHeader->l = 'Masa Berlaku';
		$csvHeader->m = 'Berlaku Dari';
		$csvHeader->n = 'Berlaku Sampai';
		$csvHeader->o = 'Batas Waktu Pembayaran';

		$csvHeader->p = 'Tanggal Pembelian';
		$csvHeader->q = 'Produk';
		$csvHeader->r = 'Subtotal';
		$csvHeader->s = 'Diskon';
		$csvHeader->t = 'Kode Voucher';
		$csvHeader->u = 'Total Pembayaran';
		$csvHeader->v = 'Payment Gateway';
		$csvHeader->w = 'Metode Pembayaran';


		$csv  = $this->arrayToCsv($csvHeader);
		$csv .= "\r\n";

		foreach ($data as $key => $value) {
			$_tmp = new stdClass();
			$_tmp->a = ($key+1);
			$_tmp->b = (!empty($value->polis_no)) ? $value->polis_no : '';
			$_tmp->c = $value->transaction_no;
			$_tmp->d = $value->invoice_no;
			$_tmp->e = ucfirst(str_replace('_', ' ', $value->status));

			$_tmp->f = (!empty($value->contact)) ? $value->contact->full_name : '';
			$_tmp->i = (!empty($value->tertanggung)) ? $value->tertanggung->full_name : '';

			$_tmp->l = ($value->status == 'aktif' or $value->status == 'berakhir') ? $value->valid_days .' hari' : '';

			$_tmp->m = ($value->status == 'aktif' or $value->status == 'berakhir') ? date('d F Y H:i:s', strtotime($value->valid_from)-25200) : '';
			$_tmp->n = ($value->status == 'aktif' or $value->status == 'berakhir') ? date('d F Y H:i:s', strtotime($value->valid_until)-25200) : '';

			$_tmp->o = ($value->status == 'pending' and !empty($value->batas_waktu_pembayaran_timestamp)) ? date('d F Y H:i:s', strtotime($value->batas_waktu_pembayaran_timestamp)) : '';
			$_tmp->p = date('d F Y H:i:s', strtotime($value->created_timestamp)-25200);
			$_tmp->q = (!empty($value->product)) ? $value->product->name : '';
			$_tmp->r = (!empty($value->trx)) ? $value->trx->total_price : '';
			$_tmp->s = (!empty($value->trx)) ? $value->trx->discount : '';
			$_tmp->t = (!empty($value->trx)) ? $value->trx->voucher_code : '';
			$_tmp->u = (!empty($value->trx)) ? $value->trx->grand_total : '';
			$_tmp->v = (!empty($value->trx)) ? ucwords($value->trx->payment_gateway) : '';
			$_tmp->w = (!empty($value->trx)) ? ucwords(str_replace('_', ' ', $value->trx->payment_method)) : '';

			$csv .= $this->arrayToCsv($_tmp);
			$csv .= "\r\n";
		}

	    header("Content-type: text/csv");
	    header("Content-Disposition: attachment; filename=transactions.csv");
	    header("Pragma: no-cache");
	    header("Expires: 0");

	    echo "\"sep=,\"\n";
		echo $csv;
		return;
	}

	public function allpolis(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		if (!empty($params['status']) and $params['status'] == 'sudah_berakhir'){
			$params['status'] = 'berakhir';
		}

		if (!empty($params['export']) && $params['export'] == 'csv'){
			return $this->exportPolis('csv');
		}

		if ( !empty($params['page']) ) $params['page'] = (int) $params['page'];
		$queryParams = http_build_query($params);
		$uri    = API_URI .'polis/all?key='. API_KEY .'&secret='. $user->secret;
		$uri   .= (!empty($params)) ? '&'. $queryParams : '';
		$vData = Array();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', $uri);

		if ( $res->getStatusCode() != 200 ){
			$vData['data'] = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $vData['data'] = $data->results;
			else $vData['data'] = null;

			if ( !empty($data->next) ){
				$nextParams = $params;
				$nextParams['page'] = (!empty($nextParams['page'])) ? ($nextParams['page'] + 1) : 1;
				$vData['next'] = site_url('content/allpolis?'. http_build_query($nextParams));
			}

			if ( !empty($data->prev) ){
				$prevParams = $params;
				$prevParams['page'] = (!empty($prevParams['page'])) ? ($prevParams['page'] - 1) : 0;
				$vData['prev'] = site_url('content/allpolis?'. http_build_query($prevParams));
			}
		}

		$this->load->view('polis/content', $vData);
	}

	public function filterpolis(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'products?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = $this->input->get();
		$vData['product'] = $data;

		$this->load->view('polis/filter', $vData);
	}

	public function allproducts(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'products?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('product/content', $vData);
	}

	public function products(){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_product < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'All Product' );
		$hData['css'][] = site_url('resources/css/medium-editor.min.css');
		$hData['css'][] = site_url('resources/css/themes/beagle.min.css');
		$vData = Array( 'data' => null );
		$fData = Array( 'js' => Array() );
		$fData['js'][] = site_url('resources/js/medium-editor.js');
		$fData['js'][] = site_url('resources/js/autolist.min.js');
		$fData['js'][] = site_url('resources/js/html.sortable.min.js');

		$this->load->view('static/head', $hData);
		$this->load->view('product/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function deletedproducts(){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_product < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'Deleted Product' );
		$hData['css'][] = site_url('resources/css/medium-editor.min.css');
		$hData['css'][] = site_url('resources/css/themes/beagle.min.css');
		$vData = Array( 'data' => null );
		$fData = Array( 'js' => Array() );
		$fData['js'][] = site_url('resources/js/medium-editor.js');
		$fData['js'][] = site_url('resources/js/autolist.min.js');
		$fData['js'][] = site_url('resources/js/html.sortable.min.js');

		$this->load->view('static/head', $hData);
		$this->load->view('product/all_deleted', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function alldeletedproducts(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'products/deleted?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('product/content_deleted', $vData);
	}

	public function sortproduct(){
		$user = $this->session->userdata('user');
		$postData = $this->input->post();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'product/'. $postData['id'] .'/sort?key='. API_KEY .'&secret='. $user->secret, Array(
			'form_params'	=> Array(
				'old_index'	=> $postData['old_index'],
				'new_index'	=> $postData['new_index'] 
			)
		));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array('status' => 500, 'message' => 'Internal server error'));
		} else {
			echo $res->getBody();
		}
	}

	public function addproduct(){
		$this->load->view('product/add');
	}

	public function deleteproduct($id){
		$user = $this->session->userdata('user');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('DELETE', API_URI .'product/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500, 'message' => 'Internal server error, mohon coba beberapa saat lagi.' ));
			return;
		}

		$data = json_decode($res->getBody());
		echo json_encode($data);
	}

	public function restoreproduct($id){
		$user = $this->session->userdata('user');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'product/'. $id .'/restore?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500, 'message' => 'Internal server error, mohon coba beberapa saat lagi.' ));
			return;
		}

		$data = json_decode($res->getBody());
		echo json_encode($data);
	}

	public function editproduct($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'product/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('product/add', $vData);
	}

	public function viewproduct($id){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_trx < 1){
			echo 'Anda tidak mempunyai hak akses untuk melihat produk. Jika ini kesalahan mohon untuk menghubungi Bagian IT';
			return;
		}


		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'product/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('product/view', $vData);
	}

	public function saveproduct(){
		$user = $this->session->userdata('user');
		$data = $this->input->post();

		if ( empty($data['name']) ){
			echo json_encode(Array( 'status' => 403, 'message' => 'Nama produk tidak boleh kosong.' ));
			return;
		}

		$postData = Array();
		$postData['name']			= $data['name'];
		$postData['product_code']	= $data['product_code'];
		$postData['descriptions']	= $data['descriptions'];
		$postData['policy']			= $data['policy'];
		$postData['can_be_bought']	= $data['can_be_bought'];
		$postData['age_min']		= $data['age_min'];
		$postData['age_max']		= $data['age_max'];
		$postData['ketentuan_umum']	= $data['ketentuan_umum'];
		$postData['info']			= Array();
		$postData['prices']			= Array();

		if ( !empty($data['info_desc']) ){ foreach ($data['info_title'] as $key => $value) {
			if ( !empty($data['info_title'][$key]) ){
				$postData['info'][] = Array(
					'id'			=> (int) $data['info_id'][$key],
					'title'			=> $data['info_title'][$key],
					'info'			=> $data['info_desc'][$key] );
			}
		}}

		if ( !empty($data['price']) ){ foreach ($data['price'] as $key => $value) {
			if ( !empty($data['price_period'][$key]) ){
				$postData['prices'][] = Array(
					'id'			=> (int) $data['price_id'][$key],
					'price'			=> $value,
					'period'		=> $data['price_period'][$key],
					'pertanggungan'	=> $data['pertanggungan'][$key] );
			}
		}}

		$client = new \GuzzleHttp\Client();
		if ( !empty($data['id']) ){
			$res = $client->request('PUT', API_URI .'product/'. $data['id'] .'?key='. API_KEY .'&secret='. $user->secret, Array(
				'form_params'	=> $postData));
		} else {
			$res = $client->request('POST', API_URI .'product?key='. API_KEY .'&secret='. $user->secret, Array(
				'form_params'	=> $postData));
		}

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 300, 'message' => 'Internal server error! Mohon coba beberapa saat lagi.' ));
			return;
		}

		$response = json_decode($res->getBody());
		if ( $response->status == 200 and !empty($_FILES) and !empty($_FILES['image']) ){
			$productID = $response->result->id;
			$res = $client->request('POST', API_URI .'product/'. $productID .'/addphoto?key='. API_KEY .'&secret='. $user->secret, Array(
    			'multipart' => Array(
    				Array(
			            'name'     	=> 'image',
		    	        'contents' 	=> fopen($_FILES['image']['tmp_name'], 'r'),
		    	        'filename'	=> $_FILES['image']['name'],
		    	        'headers'  	=> Array( 'Content-Type' => $_FILES['image']['type'] )
		    	    )
    			)
    		));

			if ( $res->getStatusCode() != 200 ){
				echo json_encode(Array( 'status' => 300, 'message' => 'Data sukses tersimpan, tetapi upload foto gagal, coba beberapa saat lagi.' ));
				return;
			}

			$addPhotoRes = json_decode($res->getBody());
			echo json_encode($addPhotoRes);
			return;
		}

		echo json_encode($response);
	}

	public function allslides(){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_slideshow < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'slides?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('slides/content', $vData);
	}

	public function slideshow(){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_slideshow < 1){
			header('Location: /error/404');
			return;
		}

		$params = $this->input->get();

		$hData = Array(
			'title'	=> 'All Slideshow' );
		$vData = Array( 'data' => null );
		$fData = Array( 'js' => Array() );
		$fData['js'][] = site_url('resources/js/html.sortable.min.js');

		$this->load->view('static/head', $hData);
		$this->load->view('slides/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function sortslide(){
		$user = $this->session->userdata('user');
		$postData = $this->input->post();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('POST', API_URI .'slide/'. $postData['id'] .'/sort?key='. API_KEY .'&secret='. $user->secret, Array(
			'form_params'	=> Array(
				'old_index'	=> $postData['old_index'],
				'new_index'	=> $postData['new_index'] 
			)
		));

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array('status' => 500, 'message' => 'Internal server error'));
		} else {
			echo $res->getBody();
		}
	}

	public function addslide(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'products?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$res = $client->request('GET', API_URI .'articles?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$articles = null;
		} else {
			$articles = json_decode($res->getBody());
			if ( $articles->status == 200 ) $articles = $articles->results;
			else $articles = null;
		}

		$vData = Array( 'products' => $data, 'articles' => $articles );
		$this->load->view('slides/add', $vData);
	}

	public function deleteslide($id){
		$user = $this->session->userdata('user');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('DELETE', API_URI .'slide/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500, 'message' => 'Internal server error, mohon coba beberapa saat lagi.' ));
			return;
		}

		$data = json_decode($res->getBody());
		echo json_encode($data);
	}

	public function editslide($id){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'products?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$products = null;
		} else {
			$products = json_decode($res->getBody());
			if ( $products->status == 200 ) $products = $products->results;
			else $products = null;
		}

		$res = $client->request('GET', API_URI .'slide/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->result;
			else $data = null;
		}

		$res = $client->request('GET', API_URI .'articles?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$articles = null;
		} else {
			$articles = json_decode($res->getBody());
			if ( $articles->status == 200 ) $articles = $articles->results;
			else $articles = null;
		}

		$vData = Array( 'products' => $products, 'data' => $data, 'articles' => $articles );
		$this->load->view('slides/add', $vData);
	}

	public function saveslide(){
		$user = $this->session->userdata('user');
		$data = $this->input->post();

		$client = new \GuzzleHttp\Client();
		if ( !empty($data['id']) ){
			$res = $client->request('PUT', API_URI .'slide/'. $data['id'] .'?key='. API_KEY .'&secret='. $user->secret, Array(
				'form_params'	=> $data));
		} else {
			$res = $client->request('POST', API_URI .'slide?key='. API_KEY .'&secret='. $user->secret, Array(
				'form_params'	=> $data));
		}

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 300, 'message' => 'Internal server error! Mohon coba beberapa saat lagi.' ));
			return;
		}

		$response = json_decode($res->getBody());
		if ( $response->status == 200 and !empty($_FILES) and !empty($_FILES['promo']) ){
			$slideID = $response->result->id;
			$res = $client->request('POST', API_URI .'slide/'. $slideID .'/addphoto?key='. API_KEY .'&secret='. $user->secret, Array(
    			'multipart' => Array(
    				Array(
			            'name'     	=> 'promo',
		    	        'contents' 	=> fopen($_FILES['promo']['tmp_name'], 'r'),
		    	        'filename'	=> $_FILES['promo']['name'],
		    	        'headers'  	=> Array( 'Content-Type' => $_FILES['promo']['type'] )
		    	    )
    			)
    		));

			if ( $res->getStatusCode() != 200 ){
				echo json_encode(Array( 'status' => 300, 'message' => 'Data sukses tersimpan, tetapi upload foto gagal, coba beberapa saat lagi.' ));
				return;
			}

			$addPhotoRes = json_decode($res->getBody());
			echo json_encode($addPhotoRes);
			return;
		}

		echo json_encode($response);
	}

	public function allvoucher(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'vouchers?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('voucher/content', $vData);
	}

	public function alldeletedvoucher(){
		$user = $this->session->userdata('user');
		$params = $this->input->get();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'vouchers/deleted?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$data = null;
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $data = $data->results;
			else $data = null;
		}

		$vData = Array( 'data' => $data );
		$this->load->view('voucher/content_deleted', $vData);
	}

	public function voucher(){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_voucher < 1){
			header('Location: /error/404');
			return;
		}


		$hData = Array(
			'title'	=> 'All Voucher',
			'css'	=> Array( site_url('resources/css/bootstrap-datepicker3.min.css') ) );
		$vData = Array();
		$fData = Array( 'js' => Array( site_url('resources/js/bootstrap-datepicker.min.js') ) );

		$this->load->view('static/head', $hData);
		$this->load->view('voucher/all', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function deletedvoucher(){
		$user = $this->session->userdata('user');
		if ($user->role_data->view_voucher < 1){
			header('Location: /error/404');
			return;
		}


		$hData = Array(
			'title'	=> 'Deleted Vouchers',
			'css'	=> Array() );
		$vData = Array();
		$fData = Array( 'js' => Array() );

		$this->load->view('static/head', $hData);
		$this->load->view('voucher/all_deleted', $vData);
		$this->load->view('static/footer', $fData);
	}

	public function addvoucher(){
		$this->load->view('voucher/add');
	}

	public function deletevoucher($id){
		$user = $this->session->userdata('user');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('DELETE', API_URI .'voucher/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500, 'message' => 'Internal server error, mohon coba beberapa saat lagi.' ));
			return;
		}

		$data = json_decode($res->getBody());
		echo json_encode($data);
	}

	public function restorevoucher($id){
		$user = $this->session->userdata('user');

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'voucher/'. $id .'/restore?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 500, 'message' => 'Internal server error, mohon coba beberapa saat lagi.' ));
			return;
		}

		$data = json_decode($res->getBody());
		echo json_encode($data);
	}

	public function editvoucher($id){
		$user = $this->session->userdata('user');
		$vData = Array();

		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', API_URI .'voucher/'. $id .'?key='. API_KEY .'&secret='. $user->secret);

		if ( $res->getStatusCode() != 200 ){
			$vData['error'] = 'Internal server error! Mohon coba beberapa saat lagi.';
		} else {
			$data = json_decode($res->getBody());
			if ( $data->status == 200 ) $vData['data'] = $data->result;
			else $vData['error'] = 'Internal server error! Mohon coba beberapa saat lagi.';
		}

		$this->load->view('voucher/add', $vData);
	}

	public function savevoucher(){
		$user = $this->session->userdata('user');
		$data = $this->input->post();

		if ( empty($data['code']) ){
			echo json_encode(Array( 'status' => 403, 'message' => 'Kode voucher tidak boleh kosong.' ));
			return;
		}
		if ( empty($data['discount']) ){
			echo json_encode(Array( 'status' => 403, 'message' => 'Potongan harga tidak boleh kosong.' ));
			return;
		}

		$client = new \GuzzleHttp\Client();
		if ( !empty($data['id']) ){
			$res = $client->request('PUT', API_URI .'voucher/'. $data['id'] .'?key='. API_KEY .'&secret='. $user->secret, Array(
				'form_params'	=> $data));
		} else {
			$res = $client->request('POST', API_URI .'voucher?key='. API_KEY .'&secret='. $user->secret, Array(
				'form_params'	=> $data));
		}

		if ( $res->getStatusCode() != 200 ){
			echo json_encode(Array( 'status' => 300, 'message' => 'Internal server error! Mohon coba beberapa saat lagi.' ));
			return;
		}

		$response = json_decode($res->getBody());
		echo json_encode($response);
	}
}
