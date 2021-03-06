<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Gas extends REST_Controller {

	function __construct($config = 'rest') {
			parent::__construct($config);
	}
	function index_post() {
		function All($value){
			$ini =& get_instance();
			$query = "UPDATE  `tb_gas` SET  `status_gas` =  '$value'";
			$update = $ini->db->query($query);
			if ($update) {
					$ini->response($update, 200);
			} else {
					$ini->response(array('status' => 'fail', 502));
			}

		}
		function One($id,$status){
			$ini =& get_instance();
			$data = array(
				'status_gas' => $status
			);
			$ini->db->where('id_gas', $id);
			$update = $ini->db->update('tb_gas', $data);
			if ($update) {
					$ini->response($data, 200);
			} else {
					$ini->response(array('status' => 'fail', 502));
			}
		}
		function renameSaklar($id,$value){
			$ini =& get_instance();
			$data = array(
				'nama_gas' => $value
			);
			$ini->db->where('id_gas', $id);
			$update = $ini->db->update('tb_gas', $data);
			if ($update) {
					$ini->response($data, 200);
			} else {
					$ini->response(array('status' => 'fail', 502));
			}
		}
		function Eksekusi($id,$value){
			$ini =& get_instance();
			if($value == "hidup"){
				One($id,$value);
			}
			else if($value == "mati"){
				One($id,$value);
			}
			else{
				$ini->response(array("status"=>"fail"),501);
			}
		}

		$OnAll  = $this->input->post('OnAll'); // hidupkan semua
		$OffAll = $this->input->post('OffAll'); // matikan semua
		$rename = $this->input->post('nama_gas');
		$id = $this->input->post('id_gas');
		$status = $this->input->post('status_gas');
		if(!empty($OnAll)){
			All("hidup");
		}
		else if(!empty($OffAll)){
			All("mati");
		}
		else if(!empty($id) && !empty($status)){
			if($status == "hidup"){
				Eksekusi($id,"hidup");
			}
			else if($status == "mati"){
				Eksekusi($id,"mati");
			}
			else{
				$this->response(array("status"=>"fail"), 501);
			}
		}
		else if(!empty($rename)){
			renameSaklar($id,$rename);
		}
		else{
			$this->response(array("status"=>"fail"), 501);
		}
	}
	function index_get() {
		$data = $this->db->get('tb_gas')->result();
		$this->response($data, 200);
	}
	function index_put() {
	}

	function index_delete() {
	}

}
