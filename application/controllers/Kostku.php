<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kostku extends CI_Controller {

	 public function __construct()
	 {
	 	parent::__construct();
	 	 $this->load->model('Kostku_model');
	 }
 

//////////////////////    called     ///////////////////////////////////////////////////////
	public function index()
	{		

		if ($this->session->userdata('kostku_logged_in')) {
			$lvl=$this->session->userdata('kostku_logged_in');
			if ($lvl['level']==2) {
				redirect('Admin','refresh');
			}else{
				$this->load->view('pemilik/home');
			}
			
		}else{
			$this->load->view('home');
		}
		
	}

	

	public function daftar()
	{
		$this->load->view('daftar');	
	}


/////////////////////////////   CRUD  ////////////////////////////////////////////
	public function mendaftar()
	{
		$usrnm=$this->Kostku_model->cekusername();
		$pwd=$this->input->post('pwd');
		$rpwd=$this->input->post('repwd');
		
		if ($pwd==$rpwd) {
			if ($usrnm===1) {
				$data['error']="username sudah terpakai";
				$this->load->view('daftar',$data);
			}else{
				$this->Kostku_model->insertuser();
				redirect('Kostku/daftar','refresh');
			}
		}else {
			$data['error']="Password Tidak sama";
				$this->load->view('daftar',$data);
		}
	}

	public function login()
	{
		$result=$this->Kostku_model->login();
		if ($result) {
			$userData = array();
			foreach ($result as $key) {
				$userData = array(
				'username' => $key->username,
		        'level' => $key->level,
		        'id' => $key->id_user);
			}
			$this->session->set_userdata('kostku_logged_in',$userData);
			redirect('Kostku','refresh');
		}else{
			$data['error']="username atau password tidak valid";
			$this->load->view('daftar',$data);
		}
	}


	public function logout()
	{
		$this->session->unset_userdata('kostku_logged_in');
		$this->session->sess_destroy();
		redirect('Kostku','refresh');
	}

	public function lihat_kost($id)
	{
		$this->load->view('guest/lihat_kost');
	}

	public function detail_kamar($id)
	{
		$this->load->view('guest/detail_kamar');
	}

////////////////////////  Process JSOOOOOONNN  //////////////////////////////////////////////////


	public function get_kost_by($a)
	{
		echo json_encode( $this->Kostku_model->get_kost_by($a));
	}
	public function get_info_kost_by($a)
	{
		echo json_encode( $this->Kostku_model->get_info_kost_by($a));
	}
	public function get_info_kamar_by($a)
	{
		echo json_encode( $this->Kostku_model->get_info_kamar_by($a));
	}

	public function getKostku()
	{
        echo json_encode( $this->Kostku_model->get_kost());
	}


////////////////////////  Process JSOOOOOONNN  //////////////////////////////////////////////////


	




}
