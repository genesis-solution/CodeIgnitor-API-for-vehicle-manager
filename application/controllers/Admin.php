<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {    
		parent::__construct();		  

		date_default_timezone_set('UTC');
		$this->baseurl = base_url();
        $this->siteurll = site_url();
        $this->load->model('m_admin','m_admin');	               
	}

	public function index(){
		$check_user_is_login= $this->session->all_userdata();
		if(!empty($check_user_is_login) && isset($check_user_is_login['logged_in']) && $check_user_is_login['logged_in']=='TRUE'){
			$this->load->view('header');
			$this->load->view('sidebar');
			$this->load->view('home');
			$this->load->view('footer');
		}else{
			$this->load->view('header_login');
			$this->load->view('login');		
			$this->load->view('footer');
	    }	
	}

	public function change_password(){
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('change_password');
		$this->load->view('footer');
	}

	public function change_pass(){
		$password=$this->input->post('password');	
		$ins=array('password'=>sha1($password));

		$wr=array('admin_id'=>1);
		$update=$this->db->update('tbl_admin',$ins,$wr);

		if($update){
			redirect(base_url().'index.php/admin/change_password/success');
		}else{
			redirect(base_url().'index.php/admin/change_password/fail');
		}
	}
}