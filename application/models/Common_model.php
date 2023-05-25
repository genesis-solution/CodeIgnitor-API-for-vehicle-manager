<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {
	
	public function user_login($post){

		$this->db->select('admin_id');
		$this->db->from('tbl_admin');
		$this->db->where('username',$post['username']);
		$this->db->where('password',sha1($post['password']));

		$data=$this->db->get()->row();


		if(!empty($data)){
			$user_session_data = array(
               'username'  => $post['username'],
               'user_id' => $data->admin_id,
               'logged_in' => TRUE
            );

			$this->session->set_userdata($user_session_data);

			$return_array=array('status'=>'success','msg'=>'');
			echo json_encode($return_array);
			die;

		}else{
			$return_array=array('status'=>'fail','msg'=>'Please valid username and password.');
			echo json_encode($return_array);
			die;
		}		
	}


	public function edit_title($post){		

		if($post['main_title']!=""){

			$edit_title_id=$post['title_id'];
			
			$insert_data=$post;
			$insert_data['cate_id']=implode(",",$insert_data['cate_id']);

			unset($insert_data['step']);

			$update_chcek=$this->db->update('tbl_titles',$insert_data,array('title_id'=>$edit_title_id));			


			//insert step-------------
				if($update_chcek!=""){

					//delete all previous step
						$this->db->delete('tbl_steps',array('title_id'=>$edit_title_id));
					//

					$all_step=$post['step'];
					foreach($all_step as $all_step_data){
						if($all_step_data!=""){
							$this->db->insert('tbl_steps',array('title_id'=>$edit_title_id,'step_text'=>$all_step_data));
						}
					}
				}
			//------------------------	

			//upload images if not empty

				//if(!empty($_FILES['title_image'])){ 
				if ($_FILES['title_image']['size'][0] != 0){

					$dataInfo = array();
		            $files = $_FILES;
		            $cpt = count($_FILES['title_image']['name']);		          

            		$this->load->library('upload');
		            for($i=0; $i<$cpt; $i++)
		            {      

		                $_FILES['card_image_'.$i]['name']= $files['title_image']['name'][$i];
		                $_FILES['card_image_'.$i]['type']= $files['title_image']['type'][$i];
		                $_FILES['card_image_'.$i]['tmp_name']= $files['title_image']['tmp_name'][$i];
		                $_FILES['card_image_'.$i]['error']= $files['title_image']['error'][$i];
		                $_FILES['card_image_'.$i]['size']= $files['title_image']['size'][$i];


		                $this->upload->initialize($this->set_upload_options($_FILES['card_image_'.$i]['name']));
		                $this->upload->do_upload('card_image_'.$i);
		                $dataInfo = $this->upload->data();


		                if(!empty($dataInfo['file_name'])){
		                    $t = array(                        
		                        'title_id' => $edit_title_id,
		                        'image_name'=>$dataInfo['file_name']
		                    );
		                    $dataInfo='';
		                }		                
		                $this->db->insert('tbl_images', $t);
		            }
				}
			//--------------------------
		}
		redirect(site_url().'/Dashboard/edit_title_view/'.$edit_title_id);
	}

	public function delete_tilt_image($post){
		$image_id=$post['image_id'];
		$image_name=$post['image_name'];

		$chck_date=$this->db->delete('tbl_images',array('image_id'=>$image_id));

		if($chck_date){			
			
			$path=$_SERVER['DOCUMENT_ROOT'].'health_tip/health_image/'.$image_name;
			if(file_exists($path)){
				unlink($path);
			}
			echo json_encode(array('status'=>'success'));
		}else{
			echo json_encode(array('status'=>'fail'));
		}
	}


	public function add_title($post){
		

		if($post['main_title']!=""){
			$insert_data=$post;
			$insert_data['cate_id']=implode(",",$insert_data['cate_id']);
			unset($insert_data['step']);
			unset($insert_data['Previou_image']);
			$last_in_id=$this->db->insert('tbl_titles',$insert_data);

			$new_id=$this->db->insert_id();
			$u_image='';			


			//insert step-------------
				if($last_in_id!=""){

					$all_step=$post['step'];
					foreach($all_step as $all_step_data){
						if($all_step_data!=""){
							$this->db->insert('tbl_steps',array('title_id'=>$new_id,'step_text'=>$all_step_data));
						}
					}
				}
			//------------------------	

			//upload images if not empty

				//if(!empty($_FILES['title_image'])){		


				if ($_FILES['title_image']['size'][0] != 0 && $_FILES['title_image']['error'][0] != 4){
					
					


					$dataInfo = array();
		            $files = $_FILES;
		            $cpt = count($_FILES['title_image']['name']);		          

            		$this->load->library('upload');
		            for($i=0; $i<$cpt; $i++)
		            {      

		                $_FILES['card_image_'.$i]['name']= $files['title_image']['name'][$i];
		                $_FILES['card_image_'.$i]['type']= $files['title_image']['type'][$i];
		                $_FILES['card_image_'.$i]['tmp_name']= $files['title_image']['tmp_name'][$i];
		                $_FILES['card_image_'.$i]['error']= $files['title_image']['error'][$i];
		                $_FILES['card_image_'.$i]['size']= $files['title_image']['size'][$i];


		                $this->upload->initialize($this->set_upload_options($_FILES['card_image_'.$i]['name']));
		                $this->upload->do_upload('card_image_'.$i);
		                $dataInfo = $this->upload->data();


		                if(!empty($dataInfo['file_name'])){
		                	$u_image=$dataInfo['file_name'];
		                    $t = array(                        
		                        'title_id' => $new_id,
		                        'image_name'=>$u_image
		                    );
		                    $dataInfo='';
		                }		                
		                $this->db->insert('tbl_images', $t);
		            }

				}else if(!empty($post['Previou_image'])){	

					$u_image=$post['Previou_image'];

                    $t = array(                        
                        'title_id' => $new_id,
                        'image_name'=>$u_image
                    );			
					$this->db->insert('tbl_images', $t);
				}
			//--------------------------
		}				
		redirect(site_url().'/Dashboard/add_title_view/'.$u_image);
	}


	private function set_upload_options($files_t)
    {   
        //upload an image options
        $config = array();
        $temp = explode(".",$files_t);       
        $config['file_name']= rand(1,1000).time().round(microtime(true)) . '.' . end($temp);
        $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/health_tip/health_image';         
        $config['allowed_types'] = 'gif|jpg|jpeg|png';          
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;
        return $config;
    }

	public function get_pd_week(){
		$this->db->select('*');
		$this->db->from('tbl_pd_weeks');
		$this->db->where('is_deleted','0');
		return $this->db->get()->result();
	}

	public function get_categories(){
		$this->db->select('*');
		$this->db->from('tbl_categories');		
		return $this->db->get()->result();
	}

	public function select_upload_image(){
		$this->db->select('image_name');
		$this->db->from('tbl_images');		
		$this->db->group_by('image_name');		
		return $this->db->get()->result();
	}

	public function get_language(){
		$this->db->select('*');
		$this->db->from('tbl_language');		
		return $this->db->get()->result();
	}

	public function get_total(){
		return	$this->db->query('SELECT count(*) as total_record FROM tbl_titles')->result();
	}


	public function manage_title(){				

		$this->load->library('pagination');

	 	$config['base_url'] = site_url().'/Dashboard/manage_title';
		$config['total_rows'] = $this->get_total()[0]->total_record;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	 	$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;	

		 $config['full_tag_open'] = '<div class="pagination"><ul>';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';

		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';

		$config['anchor_class'] = 'follow_link';

		$this->pagination->initialize($config);		
	    $link=$this->pagination->create_links();    

	    $page = $this->uri->segment(3);
        $offset = !$page?0:$page;

    	$data['data'] =$this->db->query("SELECT titl.*,lan.language_name as language_name FROM tbl_titles as titl join tbl_categories as cat on FIND_IN_SET(cat.cate_id,titl.cate_id)
		    join tbl_language as lan on (lan.language_id=titl.language_id) GROUP BY titl.title_id
		    LIMIT {$offset},{$config['per_page']}")->result();	
    	$data['paggination']=$link;
    	return $data;    	
	}

	public function get_image_by_title_id($title_id){
		$wr=array('title_id'=>$title_id);		
		return $this->db->get_where('tbl_images',$wr)->result();
	}

	public function get_title_by_id($id){

		$title_data= $this->db->query("SELECT * FROM tbl_titles WHERE title_id=$id")->result();
		$image_data=$this->db->query("SELECT * FROM tbl_images WHERE title_id=$id")->result();
		$step_data=$this->db->query("SELECT step_id,step_text FROM tbl_steps WHERE title_id=$id")->result();

		$array=array(
			'title_data'=>$title_data,
			'image_data'=>$image_data,
			'step_data'=>$step_data
		);

		return $array;
	}

	public function soft_delete_week($id){

		$this->db->where('week_id', $id);
        $check=$this->db->delete('tbl_pd_weeks');

        $return=array();
        if($check){
        	$return=array('status'=>'success');
        }else{
        	$return=array('status'=>'fail','msg'=>'Please try again!');
        }
        echo json_encode($return);
	}

	public function soft_delete_links($id){

		$this->db->where('link_id', $id);
        $check=$this->db->delete('tbl_link');

        $return=array();
        if($check){
        	$return=array('status'=>'success');
        }else{
        	$return=array('status'=>'fail','msg'=>'Please try again!');
        }
        echo json_encode($return);
	}



	public function delete_title($id){

		$this->db->where('title_id', $id);
        $check=$this->db->delete('tbl_titles');

        $return=array();
        if($check){
        	$return=array('status'=>'success');
        }else{
        	$return=array('status'=>'fail','msg'=>'Please try again!');
        }
        echo json_encode($return);
	}


	public function delete_language($id){

		$this->db->where('language_id', $id);
        $check=$this->db->delete('tbl_language');

        $return=array();
        if($check){
        	$return=array('status'=>'success');
        }else{
        	$return=array('status'=>'fail','msg'=>'Please try again!');
        }
        echo json_encode($return);
	}





	public function delete_category($id){

		$this->db->where('cate_id', $id);
        $check=$this->db->delete('tbl_categories');

        $return=array();
        if($check){
        	$return=array('status'=>'success');
        }else{
        	$return=array('status'=>'fail','msg'=>'Please try again!');
        }
        echo json_encode($return);
	}

	public function soft_delete_sjdb($id){
		$this->db->where('sjdb_id', $id);
        $check=$this->db->delete('tbl_sjdbb');

        $return=array();
        if($check){
        	$return=array('status'=>'success');
        }else{
        	$return=array('status'=>'fail','msg'=>'Please try again!');
        }
        echo json_encode($return);
	}


	public function add_location($all_data){

		$array=(array) $all_data;

		$array['created_date']=date('Y-m-d H:i:s');
		$array['updated_date']=date('Y-m-d H:i:s');

		unset($array['method']);

		$insert_id=$this->db->insert('tbl_location',$array);

		if($insert_id){
			echo json_encode(array('status'=>'success','msg'=>'Recode success inserted.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}
	}	

	public function add_category($all_data){

		$array=(array) $all_data;

		$array['created_date']=date('Y-m-d H:i:s');
		$array['updated_date']=date('Y-m-d H:i:s');

		unset($array['method']);

		$insert_id=$this->db->insert('tbl_categories',$array);

		if($insert_id){
			echo json_encode(array('status'=>'success','msg'=>'Recode success inserted.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}
	}


	public function add_language($all_data){

		$array=(array) $all_data;

		$array['created_date']=date('Y-m-d H:i:s');
		$array['updated_date']=date('Y-m-d H:i:s');

		unset($array['method']);

		$insert_id=$this->db->insert('tbl_language',$array);

		if($insert_id){
			echo json_encode(array('status'=>'success','msg'=>'Recode success inserted.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}
	}




	public function check_category_is_exists($cate_name,$cate_id=""){		

		$wr=array();
		if($cate_id!=""){
			$wr=array('cate_name'=>$cate_name,'cate_id !='=>$cate_id);
		}else{
			$wr=array('cate_name'=>$cate_name);
		}

		$data=$this->db->get_where('tbl_categories',$wr)->result();

		if(!empty($data)){
			return 1;
		}else{
			return 0;
		}		
	}

	public function check_language_is_exists($lang_name,$cate_id=""){		

		$wr=array();
		if($cate_id!=""){
			$wr=array('language_name'=>$lang_name,'language_id !='=>$cate_id);
		}else{
			$wr=array('language_name'=>$lang_name);
		}

		$data=$this->db->get_where('tbl_language',$wr)->result();

		if(!empty($data)){
			return 1;
		}else{
			return 0;
		}		
	}

	public function edit_sjdb($all_data){

		$array=(array) $all_data;
		
		$edit_id=$array['edit_id'];
		unset($array['method']);
		unset($array['edit_id']);

		$array['updated_date']=date('Y-m-d H:i:s');		

		$update=$this->db->update('tbl_sjdbb',$array,array('sjdb_id'=>$edit_id));

		if($update){
			echo json_encode(array('status'=>'success','msg'=>'Recode success updated.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}
	}

    public function edit_location($all_data){

		$array=(array) $all_data;
		
		$edit_id=$array['edit_id'];
		unset($array['method']);
		unset($array['edit_id']);

		$array['updated_date']=date('Y-m-d H:i:s');

		$update=$this->db->update('tbl_location',$array,array('location_id'=>$edit_id));

		if($update){
			echo json_encode(array('status'=>'success','msg'=>'Recode success updated.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}

	}

	public function edit_week($all_data){

		$array=(array) $all_data;
		
		$edit_id=$array['edit_id'];
		unset($array['method']);
		unset($array['edit_id']);

		$array['updated_date']=date('Y-m-d H:i:s');


		$update=$this->db->update('tbl_pd_weeks',$array,array('week_id'=>$edit_id));

		if($update){
			echo json_encode(array('status'=>'success','msg'=>'Recode success updated.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}
	}

	public function edit_link($all_data){

		$array=(array) $all_data;
		
		$edit_id=$array['edit_id'];
		unset($array['method']);
		unset($array['edit_id']);

		$array['updated_date']=date('Y-m-d H:i:s');


		$update=$this->db->update('tbl_link',$array,array('link_id'=>$edit_id));

		if($update){
			echo json_encode(array('status'=>'success','msg'=>'Recode success updated.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}
	}

	public function edit_language($all_data){

		$array=(array) $all_data;
		
		$edit_id=$array['edit_id'];
		unset($array['method']);
		unset($array['edit_id']);

		$array['updated_date']=date('Y-m-d H:i:s');		

		$update=$this->db->update('tbl_language',$array,array('language_id'=>$edit_id));

		if($update){
			echo json_encode(array('status'=>'success','msg'=>'Recode success updated.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}

	}



	public function edit_category($all_data){

		$array=(array) $all_data;
		
		$edit_id=$array['edit_id'];
		unset($array['method']);
		unset($array['edit_id']);

		$array['updated_date']=date('Y-m-d H:i:s');		

		$update=$this->db->update('tbl_categories',$array,array('cate_id'=>$edit_id));

		if($update){
			echo json_encode(array('status'=>'success','msg'=>'Recode success updated.'));
		}else{
			echo json_encode(array('status'=>'fail','msg'=>'Please try again'));
		}
	}


	public function get_language_by_id($id){

		$data=$this->db->get_where('tbl_language',array('language_id'=>$id))->row();
		
		if(!empty($data)){
			echo json_encode($data);
		}
	}

	public function get_category_by_id($id){

		$data=$this->db->get_where('tbl_categories',array('cate_id'=>$id))->row();
		
		if(!empty($data)){
			echo json_encode($data);
		}
	}
	

	public function change_pass($pass){

		$pass['password']=sha1($pass['password']);

		$update=$this->db->update('tbl_login',$pass);
		$return=array();
		if($update){
			$return=array('status'=>'success','msg'=>'Password successfully update.');
		}else{
			$return=array('status'=>'fail','msg'=>'Please try again.');
		}
		echo json_encode($return);
	}

}