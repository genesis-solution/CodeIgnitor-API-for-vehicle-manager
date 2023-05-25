<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicle_manage extends CI_Controller {

	public function __construct() {           		
		parent::__construct();		
        $this->load->model('m_admin','m_admin');        

        $check_user_is_login= $this->session->all_userdata();              

		if(!isset($check_user_is_login['logged_in'])){			
			redirect(base_url());
		}		
	}

	public function manage_user(){
		$info['users'] = $this->m_admin->db_select("email_id,Vehicle_id", "vehicle_master",'','email_id', 'email_id', '', '', 'all');
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('manage_user',$info);
		$this->load->view('footer');
	}

	public function show_vehicle($email_id){		
	 	
	 	$info['vehicle'] = $this->m_admin->db_select("email_id,Vehicle_id,vehicle_title,vehicle_brand,vehicle_model,vehicle_regi_no", "vehicle_master",array('email_id'=>$email_id),'', '', '', '', 'all');

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('vehicle_list',$info);
		$this->load->view('footer');
	}


	public function accident_details($vehicle_id){

		$info['vehicle'] = $this->m_admin->db_select("accident_id,vehicle_id,accident_date,accident_time,accident_driver_name,accident_amount,accident_km_reading", "accident_detail",array('vehicle_id'=>$vehicle_id),'', '', '', '', 'all');

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('accident_list',$info);
		$this->load->view('footer');
	}


	public function expense_details($vehicle_id){
		$info['vehicle'] = $this->m_admin->db_select("vehicle_id,expense_detail_type,expense_detail_amount,	expense_detail_km_reading", "expense_detail",array('vehicle_id'=>$vehicle_id),'', '', '', '', 'all');

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('expense_list',$info);
		$this->load->view('footer');
	}

	public function insurance_details($vehicle_id){

		$info['vehicle'] = $this->m_admin->db_select("vehicle_id,insurance_company,insurance_policy_type,insurance_policy_no,insurance_issue_date,insurance_expiry_date,insurance_payment_mode,insurance_amount,insurance_premium,insurance_agent_name,insurance_agent_phone", "insurance_detail",array('vehicle_id'=>$vehicle_id),'', '', '', '', 'all');

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('insurance_list',$info);
		$this->load->view('footer');
	}

	public function permit_details($vehicle_id){

		$info['vehicle'] = $this->m_admin->db_select("vehicle_id,permit_type,permit_issue_date,permit_expiry_date,permit_no,permit_cost", "permit_detail",array('vehicle_id'=>$vehicle_id),'', '', '', '', 'all');

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('permit_list',$info);
		$this->load->view('footer');
	}


	public function puc_details($vehicle_id){		

		$info['vehicle'] = $this->m_admin->db_select("puc_id,puc_no,puc_issue_date,puc_expiry_date,puc_amount,vehicle_id,puc_description", "puc_detail",array('vehicle_id'=>$vehicle_id),'', '', '', '', 'all');

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('puc_list',$info);
		$this->load->view('footer');
	}

	public function refuel_details($vehicle_id){		

		$info['vehicle'] = $this->m_admin->db_select("refuel_id,action_type,vehicle_id,refuel_date,refuel_type,refuel_amount,refuel_fuel_price,refuel_quantity,refuel_station,refuel_km_reading", "refuel_details",array('vehicle_id'=>$vehicle_id),'', '', '', '', 'all');

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('refuel_list',$info);
		$this->load->view('footer');
	}

	public function service_details($vehicle_id){		

		$info['vehicle'] = $this->m_admin->db_select("*", "service_detail",array('vehicle_id'=>$vehicle_id),'', '', '', '', 'all');

		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('service_list',$info);
		$this->load->view('footer');
	}

	public function manage_expense_type(){
		$info['type'] = $this->m_admin->db_select("*", "expense_type",'','', '', '', '', 'all');
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('expense_type',$info);
		$this->load->view('footer');

	}

	public function delete_expense_type(){
		
	  	$t_id=$this->input->post('t_id');

		$this->db->where('ExpenseTypeId',$t_id);
		$d=$this->db->delete('expense_type');		

        if($d){
        	$re=array('msg'=>'Record successfully deleted','status'=>'success');
        }else{
			$re=array('msg'=>'Please try again!','status'=>'fail');
        }

        echo json_encode($re);
	}

	public function add_expense_type(){

		$status=$this->input->post('status');
		$type_name=$this->input->post('type_name');

		$int=array('ExpenseType'=>$type_name,'status'=>$status);
		$int_status=$this->m_admin->insert_entry('expense_type',$int);

		if($int_status){
			$return=array('status'=>'success','msg'=>'Record successfully save!');
		}else{
			$return=array('status'=>'success','msg'=>'Please try again!');
		}
		echo json_encode($return);

	}


	public function edit_expense_type(){

		$status=$this->input->post('status');
		$type_name=$this->input->post('type_name');
		$type_id=$this->input->post('type_id');
		$wr=array('ExpenseTypeId'=>$type_id);

		$int=array('ExpenseType'=>$type_name,'status'=>$status);
		$int_status=$this->m_admin->update_entry('expense_type',$int,$wr);

		if($int_status){
			$return=array('status'=>'success','msg'=>'Record successfully save!');
		}else{
			$return=array('status'=>'success','msg'=>'Please try again!');
		}
		echo json_encode($return);

	}


	
}