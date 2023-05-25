<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{			
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

	public function user_login(){

		$post=$this->input->post();

		$username=$post['username'];
		$password=$post['password'];

		$return_array=array();


		if(empty($username)){
			$return_array=array('status'=>'fail','msg'=>'Please provide username.');
			echo json_encode($return_array);
			die;
		}

		if(empty($password)){
			$return_array=array('status'=>'fail','msg'=>'Please provide password.');
			echo json_encode($return_array);
			die;
		}


		$this->load->model('common_model','c_model');
		$this->c_model->user_login($post);		
	}

	public function logout(){

		$this->session->sess_destroy();
		$data=$this->session->get_userdata();
		
		redirect(base_url());

	}
}