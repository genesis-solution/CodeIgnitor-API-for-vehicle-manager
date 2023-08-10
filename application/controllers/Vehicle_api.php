<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vehicle_api extends CI_Controller {

	public function __construct() {       
	    
	    $os=$_SERVER['HTTP_USER_AGENT'];
    		
		parent::__construct();		
		date_default_timezone_set('UTC'); //UTC, EST,
		$this->baseurl = base_url();
        $this->siteurll = site_url();
        $this->load->model('m_admin','m_admin');
		$this->load->library('twilio');
        $this->info_limit = 25;
		$this->result = array();
        $this->msg = '';
        $this->ci =& get_instance();	               
	}

    public function get_summary(){

		$vehicle_id = $this->is_require($_POST, 'vehicle_id');

		$wr=array('vehicle_id'=>$vehicle_id);
		$info = $this->m_admin->db_select("vehicle_purchase_price,vehicle_km_reading", "vehicle_master", $wr ,'', '', '', '', 'all');

                $return_array=array();

                if(!empty($info)){                     
                     $return_array['vehicle_purchase_price']=$info[0]['vehicle_purchase_price'];
                }



		$info_reful = $this->m_admin->db_select("sum(`refuel_amount`) as refuel_amount,refuel_km_reading", "refuel_details", $wr ,'', '', '', '', 'all');
		
		
                if(!empty($info_reful)){                     
                    
                    
                    if($info_reful[0]['refuel_amount']!=""){
                        $return_array['refuel_amount']=$info_reful[0]['refuel_amount'];   
                    }else{
                        $return_array['refuel_amount']="0";
                    }
                }


		$info_service = $this->m_admin->db_select("sum(`service_amout`) as service_amout,service_km_reading", "service_detail", $wr ,'', '', '', '', 'all');
                if(!empty($info_service)){                     
                    if($info_service[0]['service_amout']!=""){
                        $return_array['service_amout']=$info_service[0]['service_amout'];   
                    }else{
                        $return_array['service_amout']="0";
                    }
                }


                $info_expense = $this->m_admin->db_select("sum(`expense_detail_amount`) as expense_detail_amount,expense_detail_km_reading", "expense_detail", $wr ,'', '', '', '', 'all');
                if(!empty($info_expense)){                     
                     
                     if($info_expense[0]['expense_detail_amount']!=""){
                        $return_array['expense_detail_amount']=$info_expense[0]['expense_detail_amount'];   
                    }else{
                        $return_array['expense_detail_amount']="0";
                    }
                     
                }


                $info_insu = $this->m_admin->db_select("sum(`insurance_amount`) as insurance_amount", "insurance_detail", $wr ,'', '', '', '', 'all');
                if(!empty($info_insu)){                     

                    if($info_insu[0]['insurance_amount']!=""){
                        $return_array['insurance_amount']=$info_insu[0]['insurance_amount'];   
                    }else{
                        $return_array['insurance_amount']="0";
                    }
                }


                $info_per = $this->m_admin->db_select("sum(`permit_cost`) as permit_cost", "permit_detail", $wr ,'', '', '', '', 'all');
                if(!empty($info_expense)){                     
                    
                     if($info_per[0]['permit_cost']!=""){
                        $return_array['permit_cost']=$info_per[0]['permit_cost'];   
                    }else{
                        $return_array['permit_cost']="0";
                    }
                    
                    
                }

				$total_expence_with_price=$return_array['permit_cost']+$return_array['insurance_amount']+$return_array['expense_detail_amount']+$return_array['service_amout']+$return_array['refuel_amount']+$return_array['vehicle_purchase_price'];

                $return_array['total_expence_with_price']=''.$total_expence_with_price;


				$total_expence_without_price=$return_array['permit_cost']+$return_array['insurance_amount']+$return_array['expense_detail_amount']+$return_array['service_amout']+$return_array['refuel_amount'];

				$return_array['total_expence_without_price']=''.$total_expence_without_price;


                $wr1=array('vehicle_id'=>$vehicle_id, 'category_type' => 'accident');
                $file_names = $this->m_admin->db_select("*", "upload_images", $wr1 ,'', '', '', '', 'all');

                $ii = 0;
                foreach ($file_names as $name => $item)
                {
                    if ($ii == 0)
                        $return_array['accident_images'] .= $item['file_name'];
                    else $return_array['accident_images'] .= "," . $item['file_name'];
                    $ii++;
                }

                $this->result['summary_details'] = $return_array;
                $this->_sendResponse(200);


       }


        public function vehicle_delete(){
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');

			$this->load->database();
             $this->db->where('Vehicle_id',$vehicle_id);     
             $d_flage=$this->db->delete('vehicle_master');

            if($d_flage){
		$this->_sendResponse(200);
            }else{
		$this->_sendResponse(400);
            }
       }





	public function set_vehicle_master_api(){

		$device_id = $this->is_require($_POST, 'device_id');

		$device_token = "";
		$action_type = $this->is_require($_POST, 'action_type');		

		$Vehicle_type = $this->is_require($_POST, 'vehicle_type');
		$vehicle_title = $this->is_require($_POST, 'vehicle_title');
		$vehicle_brand = $this->is_require($_POST, 'vehicle_brand');
		$vehicle_model = $this->is_require($_POST, 'vehicle_model');
		$vehicle_builde_year = $this->is_require($_POST, 'vehicle_builde_year');
		$vehicle_regi_no = $this->is_require($_POST, 'vehicle_regi_no');
		$vehicle_fuel_type = $this->is_require($_POST, 'vehicle_fuel_type');


		$email_id="";

		//update email id using device id	

		if(isset($_POST['email_id']) && $_POST['email_id']!=""){

			$email_id = $_POST['email_id'];
			$ins=array('email_id'=>$email_id);

			$wr=array('device_id'=>$device_id);					
			$this->db->update('vehicle_master',$ins,$wr);
		}

		//-------------------------------



		//$vehicle_tank_capacity = $this->is_require($_POST, 'vehicle_tank_capacity');

               if(isset($_POST['vehicle_tank_capacity']) && $_POST['vehicle_tank_capacity']!="" ){
   		$vehicle_tank_capacity = $this->is_require($_POST, 'vehicle_tank_capacity');

               }else{
                  $vehicle_tank_capacity="";

                }


		$vehicle_disply_name = $this->is_require($_POST, 'vehicle_disply_name');
		$vehicle_purchase_price = $this->is_require($_POST, 'vehicle_purchase_price');


                
               if(isset($_POST['vehicle_purchase_date']) && $_POST['vehicle_purchase_date'] !="" ){
		$vehicle_purchase_date = $this->is_require($_POST, 'vehicle_purchase_date');

               }else{
                  $vehicle_purchase_date="";

               }
               if(isset($_POST['vehicle_km_reading']) && $_POST['vehicle_km_reading']!="" ){
		$vehicle_km_reading = $this->is_require($_POST, 'vehicle_km_reading');

               }else{
                  $vehicle_km_reading ="";

               }


		$ins = array(
			'vehicle_type' => $Vehicle_type,
			'vehicle_title' => $vehicle_title,
			'vehicle_brand' => $vehicle_brand,
			'vehicle_model' => $vehicle_model,
			'vehicle_builde_year' => $vehicle_builde_year,
			'vehicle_regi_no' => $vehicle_regi_no,
			'vehicle_fuel_type' => $vehicle_fuel_type,
			'vehicle_tank_capacity' => $vehicle_tank_capacity,
			'vehicle_disply_name' => $vehicle_disply_name,
			'vehicle_purchase_price' => $vehicle_purchase_price,
			'vehicle_purchase_date' => $vehicle_purchase_date,			
			'vehicle_km_reading' => $vehicle_km_reading,
			'device_id' => $device_id,
			'device_token' => $device_token,
			'email_id'=>$email_id
		);

		if($action_type=='new'){
			$temp = $this->m_admin->insert_entry('vehicle_master', $ins, TRUE);
			$status_code="";
			if($temp){
				$status_code=200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}

		if($action_type=='update'){

			$vehicle_id = $this->is_require($_POST, 'vehicle_id');			
			$wr=array('Vehicle_id'=>$vehicle_id);					

			$temp = $this->db->update('vehicle_master',$ins,$wr);

			$status_code="";
			if($temp){
				$status_code = 200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}

	}


	public function set_accident_api(){

		$device_id = $this->is_require($_POST, 'device_id');		
		$action_type = $this->is_require($_POST, 'action_type');
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');
		$accident_date = $this->is_require($_POST, 'accident_date');
		$file_names = $this->is_require($_POST, 'file_names');
		//$accident_time = $this->is_require($_POST, 'accident_time');		
        //$accident_driver_name = $this->is_require($_POST, 'accident_driver_name');
		$accident_amount = $this->is_require($_POST, 'accident_amount');
		$accident_km_reading = $this->is_require($_POST, 'accident_km_reading');
		//$accident_description = $this->is_require($_POST, 'accident_description');

        $arr_names = [];
        if ($file_names != "")
		    $arr_names = explode(",", $file_names);

		$accident_time="";
		$accident_driver_name="";
		$accident_description="";

        if(isset($_POST['accident_time']) && $_POST['accident_time']!="" ){
		   $accident_time= $this->is_require($_POST, 'accident_time');
        }else{
			$accident_time="";
		}

		if(isset($_POST['accident_driver_name']) && $_POST['accident_driver_name']!="" ){
			$accident_driver_name= $this->is_require($_POST, 'accident_driver_name');
		}else{
			$accident_driver_name="";
		}

		if(isset($_POST['accident_description']) && $_POST['accident_description']!="" ){
			$accident_description= $this->is_require($_POST, 'accident_description');
		}else{
			$accident_description="";
		}


		$ins = array(
			'vehicle_id' => $vehicle_id,
			'accident_date' => $accident_date,
			'accident_time' => $accident_time,
			'accident_driver_name' => $accident_driver_name,
			'accident_amount' => $accident_amount,
			'accident_km_reading' => $accident_km_reading,
			'accident_description' => $accident_description
		);


		if($action_type=='new'){

			$temp = $this->m_admin->insert_entry('accident_detail',$ins,TRUE);

			$status_code="";
			if($temp){
                $wr1 = array(
                    'vehicle_id' => $vehicle_id,
                    'accident_driver_name' => $accident_driver_name
                );

                foreach ($arr_names as $file=>$item)
                {
                    $filequery = array(
                        'vehicle_id' => $vehicle_id,
                        'category_id' => $temp['last_id'],
                        'category_type' => 'accident',
                        'file_name' => $item
                    );
                    $this->m_admin->insert_entry('upload_images', $filequery, TRUE);
                }

				$status_code=200;
			}else{
				$status_code=400;
			}

			$this->_sendResponse($status_code); 
		}

		if($action_type=='update'){

			$accident_id = $this->is_require($_POST, 'accident_id');			
			$wr=array('accident_id'=>$accident_id);					

			$temp = $this->db->update('accident_detail',$ins,$wr);

            foreach ($arr_names as $file)
            {
                $wr=array('vehicle_id'=>$vehicle_id, 'category_id'=> $accident_id, 'category_type' => 'accident', 'file_name' => $file);
                $info = $this->m_admin->db_select("file_name", "upload_images", $wr ,'', '', '', '', 'all');

                if($info) {}
                else {
                    $filequery = array(
                        'vehicle_id' => $vehicle_id,
                        'category_id' => $accident_id,
                        'category_type' => 'accident',
                        'file_name' => $file
                    );
                    $this->m_admin->insert_entry('upload_images', $filequery, true);
                }
            }

			$status_code="";
			if($temp){
				$status_code = 200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}
	}

    public function set_member_api(){
 $fp = fopen('../test.txt',"wb");
         $h = fopen('../test.txt', 'r+');
         fwrite($fp, json_encode($_POST));
         fclose($fp);
        $action_type = $this->is_require($_POST, 'action_type');
        $member_id = $_POST['member_id'];
        $member_name = $this->is_require($_POST, 'member_name');
        $member_email = $this->is_require($_POST, 'member_email');
        $member_phone_number = $this->is_require($_POST, 'member_phone_number');
        $member_department = $this->is_require($_POST, 'member_department');
        $member_role = $this->is_require($_POST, 'member_role');
        $member_address = $this->is_require($_POST, 'member_address');
        $member_image = $this->is_require($_POST, 'member_image');

        $ins = array(
            'member_name' => $member_name,
            'member_email' => $member_email,
            'member_phone_number' => $member_phone_number,
            'member_department' => $member_department,
            'member_role' => $member_role,
            'member_address' => $member_address,
            'member_image' => $member_image
        );

        if($action_type=='new'){

            $temp = $this->m_admin->insert_entry('members',$ins,TRUE);
            $status_code="";
            if($temp){
                $status_code=200;
            }else{
                $status_code=400;
            }

            $this->_sendResponse($status_code);
        }

        if($action_type=='update'){

            $member_id = $this->is_require($_POST, 'member_id');
            $wr=array('member_id'=>$member_id);

            $temp = $this->db->update('members',$ins,$wr);

            $status_code="";
            if($temp){
                $status_code = 200;
            }else{
                $status_code=400;
            }
            $this->_sendResponse($status_code);
        }
    }

	public function set_expense_api(){

		$device_id = $this->is_require($_POST, 'device_id');
		//$device_token = $this->is_require($_POST, 'device_token');
		$action_type = $this->is_require($_POST, 'action_type');	
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');

		$expense_detail_type = $this->is_require($_POST, 'expense_detail_type');
		$expense_detail_amount = $this->is_require($_POST, 'expense_detail_amount');	
		//$expense_detail_km_reading = $this->is_require($_POST, 'expense_detail_km_reading');
		//$expense_detail_description = $this->is_require($_POST, 'expense_detail_description');
                $expense_date = $this->is_require($_POST, 'expense_date');


               if(isset($_POST['expense_detail_km_reading']) && $_POST['expense_detail_km_reading']!="" ){
		   $expense_detail_km_reading= $this->is_require($_POST, 'expense_detail_km_reading');
               }else{
                  $expense_detail_km_reading="";
               }

               if(isset($_POST['expense_detail_description']) && $_POST['expense_detail_description']!="" ){
		   $expense_detail_description= $this->is_require($_POST, 'expense_detail_description');
               }else{
                  $expense_detail_description="";
               }




		$ins = array(
			'vehicle_id' => $vehicle_id,
			'expense_detail_type' => $expense_detail_type,
			'expense_detail_amount' => $expense_detail_amount,
			'expense_detail_km_reading' => $expense_detail_km_reading,						
			'expense_detail_description' => $expense_detail_description,
                        'expense_date'=>$expense_date
		);	

		if($action_type=='new'){
			$temp = $this->m_admin->insert_entry('expense_detail', $ins, TRUE);
			$status_code="";
			if($temp){
				$status_code=200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}

		if($action_type=='update'){

			$expense_detail_id = $this->is_require($_POST, 'expense_detail_id');			
			$wr=array('expense_detail_id'=>$expense_detail_id);					

			$temp = $this->db->update('expense_detail',$ins,$wr);

			$status_code="";
			if($temp){
				$status_code = 200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}
	}

	public function set_insurance_api(){

		$device_id = $this->is_require($_POST, 'device_id');
		//$device_token = $this->is_require($_POST, 'device_token');
		$action_type = $this->is_require($_POST, 'action_type');	
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');

		//$insurance_company = $this->is_require($_POST, 'insurance_company');
		//$insurance_policy_type = $this->is_require($_POST, 'insurance_policy_type');			
		$insurance_policy_no = $this->is_require($_POST, 'insurance_policy_no');
		$insurance_issue_date = $this->is_require($_POST, 'insurance_issue_date');
		$insurance_expiry_date = $this->is_require($_POST, 'insurance_expiry_date');
		//$insurance_payment_mode = $this->is_require($_POST, 'insurance_payment_mode');
		$insurance_amount = $this->is_require($_POST, 'insurance_amount');
		//$insurance_premium= $this->is_require($_POST, 'insurance_premium');

		//$insurance_agent_name = $this->is_require($_POST, 'insurance_agent_name');
		//$insurance_agent_phone = $this->is_require($_POST, 'insurance_agent_phone');
		//$insurance_description = $this->is_require($_POST, 'insurance_description');


               if(isset($_POST['insurance_company']) && $_POST['insurance_company']!="" ){
		   $insurance_company= $this->is_require($_POST, 'insurance_company');
               }else{
                  $insurance_company="";
               }

               if(isset($_POST['insurance_policy_type']) && $_POST['insurance_policy_type']!="" ){
		   $insurance_policy_type= $this->is_require($_POST, 'insurance_policy_type');
               }else{
                  $insurance_policy_type="";
               }

               if(isset($_POST['insurance_payment_mode']) && $_POST['insurance_payment_mode']!="" ){
		   $insurance_payment_mode= $this->is_require($_POST, 'insurance_payment_mode');
               }else{
                  $insurance_payment_mode="";
               }

               if(isset($_POST['insurance_premium']) && $_POST['insurance_premium']!="" ){
		   $insurance_premium= $this->is_require($_POST, 'insurance_premium');
               }else{
                  $insurance_premium="";
               }

               if(isset($_POST['insurance_agent_name']) && $_POST['insurance_agent_name']!="" ){
		   $insurance_agent_name= $this->is_require($_POST, 'insurance_agent_name');
               }else{
                  $insurance_agent_name="";
               }

               if(isset($_POST['insurance_agent_phone']) && $_POST['insurance_agent_phone']!="" ){
		   $insurance_agent_phone= $this->is_require($_POST, 'insurance_agent_phone');
               }else{
                  $insurance_agent_phone="";
               }

               if(isset($_POST['insurance_description']) && $_POST['insurance_description']!="" ){
		   $insurance_description= $this->is_require($_POST, 'insurance_description');
               }else{
                  $insurance_description="";
               }







		$ins = array(
			'vehicle_id' => $vehicle_id,

			'insurance_company' => $insurance_company,
			'insurance_policy_type' => $insurance_policy_type,
			'insurance_policy_no' => $insurance_policy_no,						
			'insurance_issue_date' => $insurance_issue_date,
			'insurance_expiry_date' => $insurance_expiry_date,
			'insurance_payment_mode' => $insurance_payment_mode,
			'insurance_amount' => $insurance_amount,
			'insurance_agent_name' => $insurance_agent_name,
			'insurance_agent_phone' => $insurance_agent_phone,
			'insurance_description' => $insurance_description,
			'insurance_premium' => $insurance_premium,



		);	

		if($action_type=='new'){
			$temp = $this->m_admin->insert_entry('insurance_detail', $ins, TRUE);
			$status_code="";
			if($temp){
				$status_code=200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}

		if($action_type=='update'){

			$insurance_id = $this->is_require($_POST, 'insurance_id');			
			$wr=array('insurance_id'=>$insurance_id);					

			$temp = $this->db->update('insurance_detail',$ins,$wr);

			$status_code="";
			if($temp){
				$status_code = 200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}
	}

	public function set_permit_api(){		
		$device_id = $this->is_require($_POST, 'device_id');
		//$device_token = $this->is_require($_POST, 'device_token');
		$action_type = $this->is_require($_POST, 'action_type');	
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');


		//$permit_type = $this->is_require($_POST, 'permit_type');
		$permit_issue_date = $this->is_require($_POST, 'permit_issue_date');		
		$permit_expiry_date	 = $this->is_require($_POST, 'permit_expiry_date');		
		$permit_no = $this->is_require($_POST, 'permit_no');
		$permit_cost = $this->is_require($_POST, 'permit_cost');
		//$permit_description = $this->is_require($_POST, 'permit_description');



               if(isset($_POST['permit_type']) && $_POST['permit_type']!="" ){
		   $permit_type= $this->is_require($_POST, 'permit_type');
               }else{
                  $permit_type="";
               }

               if(isset($_POST['permit_description']) && $_POST['permit_description']!="" ){
		   $permit_description= $this->is_require($_POST, 'permit_description');
               }else{
                  $permit_description="";
               }





		$ins = array(
			'vehicle_id' => $vehicle_id,
			'permit_issue_date' => $permit_issue_date,
			'permit_expiry_date' => $permit_expiry_date,
			'permit_no' => $permit_no,
			'permit_cost' => $permit_cost,
			'permit_description' => $permit_description,
			'permit_type' => $permit_type,


		);	

		if($action_type=='new'){
			$temp = $this->m_admin->insert_entry('permit_detail', $ins, TRUE);
			$status_code="";
			if($temp){
				$status_code=200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}

		if($action_type=='update'){

			$permit_id = $this->is_require($_POST, 'permit_id');			
			$wr=array('permit_id'=>$permit_id);					

			$temp = $this->db->update('permit_detail',$ins,$wr);

			$status_code="";
			if($temp){
				$status_code = 200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}
	}

	public function set_puc_api(){

		$device_id = $this->is_require($_POST, 'device_id');
		//$device_token = $this->is_require($_POST, 'device_token');
		$action_type = $this->is_require($_POST, 'action_type');	
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');

		$puc_no = $this->is_require($_POST, 'puc_no');	
		$puc_issue_date = $this->is_require($_POST, 'puc_issue_date');		
		$puc_expiry_date = $this->is_require($_POST, 'puc_expiry_date');	
		$puc_amount	 = $this->is_require($_POST, 'puc_amount');		
		//$puc_description = $this->is_require($_POST, 'puc_description');



               if(isset($_POST['puc_description']) && $_POST['puc_description']!="" ){
		   $puc_description= $this->is_require($_POST, 'puc_description');
               }else{
                  $puc_description="";
               }

	

		$ins = array(
			'puc_no'=>$puc_no,
			'vehicle_id' => $vehicle_id,
			'puc_issue_date' => $puc_issue_date,
			'puc_expiry_date' => $puc_expiry_date,
			'puc_amount' => $puc_amount,
			'puc_description' => $puc_description,
		);	

		if($action_type=='new'){
			$temp = $this->m_admin->insert_entry('puc_detail', $ins, TRUE);
			$status_code="";
			if($temp){
				$status_code=200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}

		if($action_type=='update'){

			$puc_id = $this->is_require($_POST, 'puc_id');			
			$wr=array('puc_id'=>$puc_id);					

			$temp = $this->db->update('puc_detail',$ins,$wr);

			$status_code="";
			if($temp){
				$status_code = 200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}


	}

	public function set_service_api(){

		$device_id = $this->is_require($_POST, 'device_id');
		//$device_token = $this->is_require($_POST, 'device_token');
		$action_type = $this->is_require($_POST, 'action_type');	
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');

		
		//$service_garrage_name = $this->is_require($_POST, 'service_garrage_name');		
		//$service_contact_no = $this->is_require($_POST, 'service_contact_no');	

		$service_amout	 = $this->is_require($_POST, 'service_amout');		


        //$service_km_reading = $this->is_require($_POST, 'service_km_reading');	
		//$service_description = $this->is_require($_POST, 'service_description');	
		
		$service_clutch=0;
		$service_engine=0;
		$service_oil_change=0;
		$service_brakes=0;
		$service_colling_systerm=0;
		$service_sparkplug=0;
		$service_other=0;
		$service_battery=0;
                

		$service_garrage_name = "";
                $service_contact_no = "";
                $service_general=0;
                $service_body=0;
                $service_date="";
                $service_description="";
                $service_km_reading="";
	

	

		if(isset($_POST['service_description']) && $_POST['service_description']!=""){
                      $service_description = $this->is_require($_POST, 'service_description');
		}

		if(isset($_POST['service_km_reading']) && $_POST['service_km_reading']!=""){
			$service_km_reading=$_POST['service_km_reading'];
		}


		if(isset($_POST['service_contact_no']) && $_POST['service_contact_no']!=""){
			$service_contact_no=$_POST['service_contact_no'];
		}

		if(isset($_POST['service_garrage_name']) && $_POST['service_garrage_name']!=""){
			$service_garrage_name=$_POST['service_garrage_name'];
		}

		if(isset($_POST['service_clutch']) && $_POST['service_clutch']!=""){
			$service_clutch=$_POST['service_clutch'];
		}

		if(isset($_POST['service_engine']) && $_POST['service_engine']!=""){
			$service_engine=$_POST['service_engine'];
		}

		if(isset($_POST['service_oil_change']) && $_POST['service_oil_change']!=""){
			$service_oil_change=$_POST['service_oil_change'];
		}

		if(isset($_POST['service_brakes']) && $_POST['service_brakes']!=""){
			$service_brakes=$_POST['service_brakes'];
		}

		if(isset($_POST['service_colling_systerm']) && $_POST['service_colling_systerm']!=""){
			$service_colling_systerm=$_POST['service_colling_systerm'];
		}

		if(isset($_POST['service_sparkplug']) && $_POST['service_sparkplug']!=""){
			$service_sparkplug=$_POST['service_sparkplug'];
		}

		if(isset($_POST['service_other']) && $_POST['service_other']!=""){
			$service_other=$_POST['service_other'];
		}

		if(isset($_POST['service_battery']) && $_POST['service_battery']!=""){
			$service_battery=$_POST['service_battery'];
		}	


        if(isset($_POST['service_general']) && $_POST['service_general']!=""){
			$service_general=$_POST['service_general'];
		}

        if(isset($_POST['service_body']) && $_POST['service_body']!=""){
			$service_body=$_POST['service_body'];
		}

        if(isset($_POST['service_date']) && $_POST['service_date']!=""){
			$service_date=$_POST['service_date'];
		}



		$ins = array(			
			'vehicle_id' => $vehicle_id,
			'service_garrage_name' => $service_garrage_name,
			'service_contact_no' => $service_contact_no,
			'service_amout' => $service_amout,
			'service_km_reading' => $service_km_reading,
			'service_description' => $service_description,
			'service_clutch' => $service_clutch,			
			'service_engine' => $service_engine,
			'service_oil_change' => $service_oil_change,
			'service_brakes' => $service_brakes,
			'service_colling_systerm' => $service_colling_systerm,
			'service_sparkplug' => $service_sparkplug,
			'service_other' => $service_other,
			'service_battery' => $service_battery,
			'service_general' => $service_general,
			'service_body' => $service_body,
			'service_date' => $service_date,

		);	





		if($action_type=='new'){

			$temp = $this->m_admin->insert_entry('service_detail', $ins, TRUE);
			$status_code="";
			if($temp){
				$status_code=200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 

		}

		if($action_type=='update'){

			$service_id = $this->is_require($_POST, 'service_id');
			$wr=array('service_id'=>$service_id);					

			$temp = $this->db->update('service_detail',$ins,$wr);

			$status_code="";
			if($temp){
				$status_code = 200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}

	}	





       public function set_refuel_api(){

		$device_id = $this->is_require($_POST, 'device_id');
		$action_type = $this->is_require($_POST, 'action_type');	
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');

		$refuel_date = $this->is_require($_POST, 'refuel_date');
		//$refuel_type = $this->is_require($_POST, 'refuel_type');
		$refuel_amount = $this->is_require($_POST, 'refuel_amount');
		//$refuel_fuel_price = $this->is_require($_POST, 'refuel_fuel_price');
                //$refuel_quantity = $this->is_require($_POST, 'refuel_quantity');
                //$refuel_station = $this->is_require($_POST, 'refuel_station');
                //$refuel_km_reading = $this->is_require($_POST, 'refuel_km_reading');

                $refuel_type="";
                $refuel_fuel_price="";
                $refuel_quantity="";
                $refuel_station="";
                $refuel_km_reading="";


                if(isset($_POST['refuel_type']) && $_POST['refuel_type']!=""){
			$refuel_type=$_POST['refuel_type'];
		}

                if(isset($_POST['refuel_fuel_price']) && $_POST['refuel_fuel_price']!=""){
			$refuel_fuel_price=$_POST['refuel_fuel_price'];
		}

                if(isset($_POST['refuel_quantity']) && $_POST['refuel_quantity']!=""){
			$refuel_quantity=$_POST['refuel_quantity'];
		}

                if(isset($_POST['refuel_station']) && $_POST['refuel_station']!=""){
			$refuel_station=$_POST['refuel_station'];
		}

                if(isset($_POST['refuel_km_reading']) && $_POST['refuel_km_reading']!=""){
			$refuel_km_reading=$_POST['refuel_km_reading'];
		}

		$ins = array(
			'vehicle_id' => $vehicle_id,
			'action_type' => $action_type,
			'device_id' => $device_id,
			'refuel_date' => $refuel_date,
			'refuel_type' => $refuel_type,
			'refuel_amount' => $refuel_amount,
			'refuel_fuel_price' => $refuel_fuel_price,
			'refuel_quantity' => $refuel_quantity,
			'refuel_station' => $refuel_station,
			'refuel_km_reading' => $refuel_km_reading
                        
		);	

		if($action_type=='new'){
			$temp = $this->m_admin->insert_entry('refuel_details', $ins, TRUE);
			$status_code="";
			if($temp){
				$status_code=200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}

		if($action_type=='update'){

			$refuel_id = $this->is_require($_POST, 'refuel_id');			
			$wr=array('refuel_id'=>$refuel_id);					

			$temp = $this->db->update('refuel_details',$ins,$wr);

			$status_code="";
			if($temp){
				$status_code = 200;
			}else{
				$status_code=400;
			}
			$this->_sendResponse($status_code); 
		}
	}


//========================================================================//

        function get_vehicle_data(){		

		$Vehicle_id = $this->is_require($_POST, 'Vehicle_id');

		$wr=array('Vehicle_id'=>$Vehicle_id);
		$info = $this->m_admin->db_select("*", "vehicle_master", $wr ,'', '', '', '', 'all');

		$data_array = array();

		foreach($info as $ins => $inf){
			$data_array['Vehicle_id'] = $inf['Vehicle_id'];
			$data_array['Vehicle_type'] = $inf['Vehicle_type'];
			$data_array['vehicle_title'] = $inf['vehicle_title'];
			$data_array['vehicle_brand'] = $inf['vehicle_brand'];
			$data_array['vehicle_model'] = $inf['vehicle_model'];
			$data_array['vehicle_builde_year'] = $inf['vehicle_builde_year'];
			$data_array['vehicle_regi_no'] = $inf['vehicle_regi_no'];
			$data_array['vehicle_fuel_type'] = $inf['vehicle_fuel_type'];
			$data_array['vehicle_tank_capacity'] = $inf['vehicle_tank_capacity'];

			$data_array['vehicle_disply_name'] = $inf['vehicle_disply_name'];
			$data_array['vehicle_purchase_date'] = $inf['vehicle_purchase_date'];
			$data_array['vehicle_purchase_price'] = $inf['vehicle_purchase_price'];
			$data_array['vehicle_km_reading'] = $inf['vehicle_km_reading'];
			$data_array['device_id'] = $inf['device_id'];
			$data_array['device_token'] = $inf['device_token'];
			$data_array['updated_date'] = $inf['created_date'];
		//	$i++;
		}

		$this->result['vehicle_details'] = $data_array;
		$this->_sendResponse(200);
	}


	function get_vehicle_master(){				

		$device_id = $this->is_require($_POST, 'device_id');


		if(isset($_POST['email_id']) && $_POST['email_id']!=""){
			$email_id=$_POST['email_id'];
			$info = $this->m_admin->select_custom("select * from vehicle_master where email_id='{$email_id}' or device_id='{$device_id}'");	
		}else{			
			$info = $this->m_admin->select_custom("select * from vehicle_master where device_id='{$device_id}'");
		}			
		
		$data_array = array();
		$i = 0;
		foreach($info as $ins => $inf){
			$data_array[$i]['Vehicle_id'] = $inf['Vehicle_id'];
			$data_array[$i]['Vehicle_type'] = $inf['Vehicle_type'];
			$data_array[$i]['vehicle_title'] = $inf['vehicle_title'];
			$data_array[$i]['vehicle_brand'] = $inf['vehicle_brand'];
			$data_array[$i]['vehicle_model'] = $inf['vehicle_model'];
			$data_array[$i]['vehicle_builde_year'] = $inf['vehicle_builde_year'];
			$data_array[$i]['vehicle_regi_no'] = $inf['vehicle_regi_no'];
			$data_array[$i]['vehicle_fuel_type'] = $inf['vehicle_fuel_type'];
			$data_array[$i]['vehicle_tank_capacity'] = $inf['vehicle_tank_capacity'];

			$data_array[$i]['vehicle_disply_name'] = $inf['vehicle_disply_name'];
			$data_array[$i]['vehicle_purchase_date'] = $inf['vehicle_purchase_date'];
			$data_array[$i]['vehicle_purchase_price'] = $inf['vehicle_purchase_price'];
			$data_array[$i]['vehicle_km_reading'] = $inf['vehicle_km_reading'];
			$data_array[$i]['device_id'] = $inf['device_id'];
			$data_array[$i]['device_token'] = $inf['device_token'];
			$data_array[$i]['updated_date'] = $inf['created_date'];
			$i++;
		}

		$this->result['vehicle_details'] = $data_array;
		$this->_sendResponse(200);
	}

    function get_member_master(){
        $info = $this->m_admin->select_custom("select * from members");
        $this->result['member_details'] = $info;
        $this->_sendResponse(200);
    }



	function get_vehicle_master1(){		

		$device_id = $this->is_require($_POST, 'device_id');


		if(isset($_POST['email_id']) && $_POST['email_id']!=""){
			$email_id=$_POST['email_id'];
			$wr=array('email_id'=>$email_id);			
	
		}else{
			$wr=array('device_id'=>$device_id);						
		}	

	$info = $this->m_admin->db_select("*", "vehicle_master", $wr ,'', '', '', '', 'all');

	


		$data_array = array();
		$i = 0;
		foreach($info as $ins => $inf){
			$data_array[$i]['Vehicle_id'] = $inf['Vehicle_id'];
			$data_array[$i]['Vehicle_type'] = $inf['Vehicle_type'];
			$data_array[$i]['vehicle_title'] = $inf['vehicle_title'];
			$data_array[$i]['vehicle_brand'] = $inf['vehicle_brand'];
			$data_array[$i]['vehicle_model'] = $inf['vehicle_model'];
			$data_array[$i]['vehicle_builde_year'] = $inf['vehicle_builde_year'];
			$data_array[$i]['vehicle_regi_no'] = $inf['vehicle_regi_no'];
			$data_array[$i]['vehicle_fuel_type'] = $inf['vehicle_fuel_type'];
			$data_array[$i]['vehicle_tank_capacity'] = $inf['vehicle_tank_capacity'];

			$data_array[$i]['vehicle_disply_name'] = $inf['vehicle_disply_name'];
			$data_array[$i]['vehicle_purchase_date'] = $inf['vehicle_purchase_date'];
			$data_array[$i]['vehicle_purchase_price'] = $inf['vehicle_purchase_price'];
			$data_array[$i]['vehicle_km_reading'] = $inf['vehicle_km_reading'];
			$data_array[$i]['device_id'] = $inf['device_id'];
			$data_array[$i]['device_token'] = $inf['device_token'];
			$data_array[$i]['updated_date'] = $inf['created_date'];
			$i++;
		}

		$this->result['vehicle_details'] = $data_array;
		$this->_sendResponse(200);
	}


	function get_accident_api(){			

		$vehicle_id = $this->is_require($_POST, 'vehicle_id');
		$wr=array('vehicle_id'=>$vehicle_id);
		$info = $this->m_admin->db_select("*", "accident_detail", $wr ,'', '', '', '', 'all');

		$data_array = array();
		$i = 0;
		foreach($info as $ins => $inf){
			$data_array[$i]['accident_id'] = $inf['accident_id'];
			$data_array[$i]['accident_date'] = $inf['accident_date'];
			$data_array[$i]['accident_time'] = $inf['accident_time'];

			$data_array[$i]['accident_driver_name'] = $inf['accident_driver_name'];
			$data_array[$i]['accident_amount'] = $inf['accident_amount'];
			$data_array[$i]['accident_km_reading'] = $inf['accident_km_reading'];
			$data_array[$i]['accident_description'] = $inf['accident_description'];
			$data_array[$i]['date_create'] = $inf['date_create'];

            $wr1=array('vehicle_id'=>$vehicle_id, 'category_id' => $inf['accident_id'], 'category_type' => 'accident');
            $file_names = $this->m_admin->db_select("*", "upload_images", $wr1 ,'', '', '', '', 'all');
            $ii = 0;
            foreach ($file_names as $name => $item)
            {
                if ($ii == 0)
                    $data_array[$i]['accident_images'] .= $item['file_name'];
                else $data_array[$i]['accident_images'] .= "," . $item['file_name'];
                $ii++;
            }

			$i++;
		}

		$this->result['accident_details'] = $data_array;
		$this->_sendResponse(200);
	}

	function upload_vehicle() {
		$place = $this->is_require($_POST, 'place');
		
		
		$decoded=base64_decode($this->is_require($_POST, 'pic'));
		
		$directory = './images/uploads/';
		
		if ($place == 'accident') {
			$directory = $directory . "accident/";
		}
		if (!is_dir($directory)) {
			mkdir($directory, 0777, true);
		}
		$file_name = uniqid() . '.JPG';
		$file_path = $directory . $file_name;
		
		if (file_put_contents($file_path, $decoded)) {
			$this->result['filename'] = $file_name;
			$this->_sendResponse(200);
		} else {
			$this->_sendResponse(500);
		}
	}

    function upload_avatar() {
        // $fp = fopen('../test.txt',"wb");
        // $h = fopen('../test.txt', 'r+');
        // fwrite($fp, $this->is_require($_POST, 'pic'));
        // fclose($fp);
        $place = $this->is_require($_POST, 'place');

        $decoded=base64_decode($this->is_require($_POST, 'pic'));

        $directory = './images/uploads/';

        if ($place == 'accident') {
            $directory = $directory . "users/";
        }
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        $file_name = uniqid() . '.JPG';
        $file_path = $directory . $file_name;

        if (file_put_contents($file_path, $decoded)) {
            $this->result['filename'] = $file_name;
            $this->_sendResponse(200);
        } else {
            $this->_sendResponse(500);
        }
    }


	function get_expense_api(){

		$vehicle_id = $this->is_require($_POST, 'vehicle_id');
		$wr=array('vehicle_id'=>$vehicle_id);
		$info = $this->m_admin->db_select("*", "expense_detail", $wr ,'', '', '', '', 'all');

		$data_array = array();
		$i = 0;
		foreach($info as $ins => $inf){
			$data_array[$i]['expense_detail_id'] = $inf['expense_detail_id'];
			$data_array[$i]['expense_detail_type'] = $inf['expense_detail_type'];
			$data_array[$i]['expense_detail_amount'] = $inf['expense_detail_amount'];
			$data_array[$i]['expense_detail_km_reading'] = $inf['expense_detail_km_reading'];
			$data_array[$i]['expense_detail_description'] = $inf['expense_detail_description'];
			$data_array[$i]['expense_date'] = $inf['expense_date'];
			$data_array[$i]['date_create'] = $inf['date_create'];			
			$i++;
		}

		$this->result['expense_details'] = $data_array;
		$this->_sendResponse(200);
	}


	function get_insurance_api(){
		$vehicle_id = $this->is_require($_POST, 'vehicle_id');
		$wr=array('vehicle_id'=>$vehicle_id);
		$info = $this->m_admin->db_select("*", "insurance_detail", $wr ,'', '', '', '', 'all');

		$data_array = array();
		$i = 0;
		foreach($info as $ins => $inf){
			$data_array[$i]['insurance_id'] = $inf['insurance_id'];

			$data_array[$i]['insurance_company'] = $inf['insurance_company'];
			$data_array[$i]['insurance_policy_type'] = $inf['insurance_policy_type'];
			$data_array[$i]['insurance_policy_no'] = $inf['insurance_policy_no'];
			$data_array[$i]['insurance_issue_date'] = $inf['insurance_issue_date'];
			$data_array[$i]['insurance_expiry_date'] = $inf['insurance_expiry_date'];
			$data_array[$i]['insurance_payment_mode'] = $inf['insurance_payment_mode'];
			$data_array[$i]['insurance_amount'] = $inf['insurance_amount'];
			$data_array[$i]['insurance_premium'] = $inf['insurance_premium'];
			$data_array[$i]['insurance_agent_name'] = $inf['insurance_agent_name'];
			$data_array[$i]['insurance_agent_phone'] = $inf['insurance_agent_phone'];			
			$data_array[$i]['insurance_description'] = $inf['insurance_description'];
			$data_array[$i]['date_create'] = $inf['date_create'];			
			$i++;
		}

		$this->result['insurance_details'] = $data_array;
		$this->_sendResponse(200);
	}


	function get_permit_api(){	

		$vehicle_id = $this->is_require($_POST, 'vehicle_id');
		$wr=array('vehicle_id'=>$vehicle_id);
		$info = $this->m_admin->db_select("*", "permit_detail", $wr ,'', '', '', '', 'all');

		$data_array = array();
		$i = 0;
		foreach($info as $ins => $inf){
			$data_array[$i]['permit_id'] = $inf['permit_id'];

			$data_array[$i]['permit_type'] = $inf['permit_type'];
			$data_array[$i]['permit_issue_date'] = $inf['permit_issue_date'];

			$data_array[$i]['permit_expiry_date'] = $inf['permit_expiry_date'];
			$data_array[$i]['permit_no'] = $inf['permit_no'];
			$data_array[$i]['permit_cost'] = $inf['permit_cost'];
			$data_array[$i]['permit_description'] = $inf['permit_description'];					
			$i++;
		}
		$this->result['permit_details'] = $data_array;
		$this->_sendResponse(200);
	}

	function get_puc_api(){

		$vehicle_id = $this->is_require($_POST, 'vehicle_id');
		$wr=array('vehicle_id'=>$vehicle_id);
		$info = $this->m_admin->db_select("*", "puc_detail", $wr ,'', '', '', '', 'all');

		$data_array = array();
		$i = 0;
		foreach($info as $ins => $inf){
			$data_array[$i]['puc_no'] = $inf['puc_no'];
			$data_array[$i]['puc_id'] = $inf['puc_id'];

			$data_array[$i]['puc_issue_date'] = $inf['puc_issue_date'];
			$data_array[$i]['puc_expiry_date'] = $inf['puc_expiry_date'];
			$data_array[$i]['puc_amount'] = $inf['puc_amount'];
			$data_array[$i]['puc_description'] = $inf['puc_description'];			
			$i++;
		}

		$this->result['puc_details'] = $data_array;
		$this->_sendResponse(200);

	}

	function get_service_api(){

		$vehicle_id = $this->is_require($_POST, 'vehicle_id');
		$wr=array('vehicle_id'=>$vehicle_id);
		$info = $this->m_admin->db_select("*", "service_detail", $wr ,'', '', '', '', 'all');

		$data_array = array();
		$i = 0;
                

		foreach($info as $ins => $inf){
$return_string="";
			$data_array[$i]['service_id'] = $inf['service_id'];
			$data_array[$i]['service_body'] = $inf['service_body'];
			$data_array[$i]['service_clutch'] = $inf['service_clutch'];
			$data_array[$i]['service_engine'] = $inf['service_engine'];
			$data_array[$i]['service_oil_change'] = $inf['service_oil_change'];
			$data_array[$i]['service_brakes'] = $inf['service_brakes'];
			$data_array[$i]['service_colling_systerm'] = $inf['service_colling_systerm'];
			$data_array[$i]['service_sparkplug'] = $inf['service_sparkplug'];			
			$data_array[$i]['service_other'] = $inf['service_other'];
			$data_array[$i]['service_battery'] = $inf['service_battery'];
			$data_array[$i]['service_garrage_name'] = $inf['service_garrage_name'];
			$data_array[$i]['service_contact_no'] = $inf['service_contact_no'];
			$data_array[$i]['service_amout'] = $inf['service_amout'];
			$data_array[$i]['service_km_reading'] = $inf['service_km_reading'];
			$data_array[$i]['service_description'] = $inf['service_description'];
			$data_array[$i]['service_date'] = $inf['service_date'];
			$data_array[$i]['service_general'] = $inf['service_general'];
			$data_array[$i]['date_create'] = $inf['date_create'];



                        if($inf['service_body']==1){
                            $return_string.="Body, ";
                        }

                        if($inf['service_clutch']==1){
                            $return_string.="Clutch, ";
                        }

                        if($inf['service_engine']==1){
                            $return_string.="Engine, ";
                        }

                        if($inf['service_oil_change']==1){
                            $return_string.="Oil change, ";
                        }

                        if($inf['service_brakes']==1){
                            $return_string.="Brakes, ";
                        }

                        if($inf['service_colling_systerm']==1){
                            $return_string.="Colling System, ";
                        }

                        if($inf['colling systerm']==1){
                            $return_string.="Colling System, ";
                        }

                        if($inf['service_sparkplug']==1){
                            $return_string.="Sparkplug, ";
                        }

                        if($inf['service_other']==1){
                            $return_string.="Other, ";
                        }

                        if($inf['service_battery']==1){
                            $return_string.="Battery, ";
                        }

                        if($inf['service_general']==1){
                            $return_string.="General, ";
                        }

                        $return_string=rtrim($return_string," ");
                        $return_string=rtrim($return_string,",");

                        $data_array[$i]['sevice_selected']=rtrim($return_string,",");

			$i++;
		}

		$this->result['service_details'] = $data_array;
		$this->_sendResponse(200);
	}


        function get_refuel_api(){

		$vehicle_id = $this->is_require($_POST, 'vehicle_id');
		$wr=array('vehicle_id'=>$vehicle_id);
		$info = $this->m_admin->db_select("*", "refuel_details", $wr ,'', '', '', '', 'all');

		$data_array = array();
		$i = 0;
		foreach($info as $ins => $inf){
			$data_array[$i]['refuel_date'] = $inf['refuel_date'];
			$data_array[$i]['refuel_id'] = $inf['refuel_id'];
			$data_array[$i]['refuel_type'] = $inf['refuel_type'];
			$data_array[$i]['refuel_amount'] = $inf['refuel_amount'];
			$data_array[$i]['refuel_fuel_price'] = $inf['refuel_fuel_price'];
			$data_array[$i]['refuel_quantity'] = $inf['refuel_quantity'];
			$data_array[$i]['refuel_station'] = $inf['refuel_station'];
			$data_array[$i]['refuel_km_reading'] = $inf['refuel_km_reading'];
			$i++;
		}

		$this->result['refuel_details'] = $data_array;
		$this->_sendResponse(200);
	}
	

/*============================
		Private Function Start
		=============================*/	
	
	private function is_require($a, $i) {		
		
        if (!isset($a[$i]) || $a[$i] == '') {       	

            //$this->msg = $i . " parameter missing or it should not null";
            $this->msg = $this->_getErrorCodeMessage($i);
            $this->_sendResponse(500);
        } else {
            return $a[$i];
        }
    }
	
	private function _getErrorCodeMessage($status) {

        $codes = Array(

        	'action_type'=>'Action type is required',        	
        	'service_general'=>'Service general is required.',
        	'service_amout'=>'Service amount is required.',
        	'service_body'=>'Service body is required',
        	'service_date'=>'Service data is required',
        	'service_engine'=>'Service engine is required',
        	'service_oil_change'=>'service oil change is required',
        	'service_brakes'=>'Service Brakes is required',
        	'service_colling_systerm'=>'Service colling system is required.',
        	'service_sparkplug'=>'Service Sparkplug is required.',
        	'service_other'=>'Service other is required.',
        	'service_battery'=>'Service battery is required.',
        	'service_garrage_name'=>'Service garrage name is required.',
        	'service_contact_no'=>'Service contact no is required.',
        	'service_description'=>'Service description is required',

            'device_id' => 'Device Id is  required',
			'device_type' => 'Device type is required',
			'device_token' => 'Device token is required',
			'action_type' => 'Action type is required',
			'vehicle_type'=>'Vehicle type is required',
			'vehicle_title'=>'Vehicle title is required',
			'vehicle_brand'=>'Vehicle brand is required',
			'vehicle_model'=>'Vehicle model is required',
			'vehicle_builde_year'=>'Vehicle builde year is required',
			'vehicle_regi_no'=>'Vehicle registration nomber is required',
			'vehicle_tank_capacity'=>'Vehicle tank capacity is required',
			'vehicle_disply_name'=>'Vehicle dispay name is required',
			'vehicle_km_reading'=>'Vehicle km reading is required',
			'vehicle_id'=>'Vehicle id is required',
			'vehicle_fuel_type'=>'Vehicle fuel type required',
			'vehicle_purchase_price'=>'Vehicle purchase price is requested',

			
			'accident_id'=>'Accident accident id is required',
			'accident_date'=>'Accident date is required',
			'accident_time'=>'Accident time is required',
			'accident_driver_name'=>'Accident driver name is required',
			'accident_amount'=>'Accident amount is required',
			'accident_km_reading'=>'Accident km reading is required',
			'accident_description'=>'Accident description is required',		
			'pic' => 'File not found',
			'place' => 'parameter invalid',
			'file_names' => "Please upload the images",


			'expense_detail_type'=>'Expense type is required',
			'expense_detail_amount'=>'Expense amount is required',
			'expense_detail_km_reading'=>'Expense kilo-meter reading is required',
			'expense_detail_description'=>'Expense description is required',
			'expense_detail_id'=>'Expense id is required',


			'insurance_company'=>'Company is required',
			'insurance_policy_type'=>'Policy type is required',
			'insurance_policy_no'=>'Policy no is required',
			'insurance_issue_date'=>'Issue date is required',
			'insurance_expiry_date'=>'Expriy date is required',
			'insurance_payment_mode'=>'Payment mode is required',
			'insurance_amount'=>'Insurance amount is required',
			'insurance_agent_name'=>'Insurance agent name is required',
			'insurance_agent_phone'=>'Insurance agent phone is required',
			'insurance_description'=>'Insurance description is required',	
			'insurance_id'=>'Insurance id is required',


			'puc_no'=>'Puc number is Required',		
			'puc_issue_date'=>'Puc issue date is Required',
			'puc_expiry_date'=>'Puc expriy date is Required',
			'puc_amount'=>'Puc amount is Required',
			'puc_description'=>'Puc description is Required',

            'member_id'=>'ID is Required',
            'member_name'=>'Name is Required',
            'member_email'=>'Email is Required',
            'member_phone_number'=>'Phone number is Required',
            'member_role'=>'Role is Required',
            'member_address'=>'Address is Required',
            'member_image'=>'Avatar image is Required',
            'member_department'=>'Department is Required',

		);
		
		return (isset($codes[$status])) ? $codes[$status] : '';
	}

  
	
	private function _sendResponse($status_code = 200) {
        if ($this->msg == '') {
            $this->msg = $this->_getStatusCodeMessage($status_code);
        }
        $this->result['msg'] = $this->msg;
        $this->result['status_code'] = $status_code;
        echo json_encode($this->result);
        die();
    }

    private function _resul($st = 200){
		if ($this->msg == '') {
            $this->msg = $this->_getStatusCodeMessage($st);
        }
        $this->result['Result'] = $this->msg;
        $this->result['status_code'] = $st;
        echo json_encode($this->result);
        die();
    }
	
    private function _getStatusCodeMessage($status) {

        $codes = Array(
            101 => 'Required field missing',
			200 => 'OK',
			203 => 'Email is not valid, please enter correct Email',
			204 => 'Update status failed, please try again',
			301 => 'Something went wrong, please try again',
			303 => 'Wrong verification code, please enter correct code',
			400 => 'Bad request',
			401 => 'You must be authorized to view this page',
			404 => 'The requested URL was not found',
			405 => 'Send message failed, please try again',
			701 => 'Registration process failed, please try again',
			702 => 'Profile update failed, please try again',
			703 => 'Notification update failed, please try again',
			704 => 'Session has expired, please wait for customer response',
			705 => 'Profile image update failed, please try again',
			706 => 'Chat delete failed, please try again',
			714 => 'Customer is logged out',
			801 => 'You don\'t have permission to access data',
			802=>  'You are not eligible to change note because client have not paid fees.',
			803=> 'No client availale.',
			804=> 'You are not eligible to change away message',
			805=> 'You are not eligible to change status',
			1000 => 'Your current account is deactivated',
		);		
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

}