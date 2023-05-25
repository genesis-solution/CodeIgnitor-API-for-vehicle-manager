<?php

class M_admin extends CI_Model {

    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry($tbl,$arr,$flag)
    {
        $r=array('stat'=>0,'last_id'=>0);
        $r['stat']=$this->db->insert($tbl, $arr);
        if($flag==1 && $r['stat']==1){
            $r['last_id']=$this->db->insert_id();
        }
        return $r;
    }

    function update_entry($t,$i,$w)
    {
       
       return $this->db->update($t, $i,$w);
    }
	    
    function db_select($select,$from,$where=array(),$group='',$order='',$having='',$limit='',$result_way='all',$echo=0)
    {
        $result=array();
        $this->db->select($select);
        $this->db->from($from);
        if(!empty($where)){
            $this->db->where($where);
        }
        if($limit!=''){
            $exp_lim=explode(",", $limit);
            $offset=  reset($exp_lim);
            $limit=  end($exp_lim);
            $this->db->limit($limit,$offset);
        }
        if($order != ''){
            $this->db->order_by($order); 
        }
        if($group != ''){
            $this->db->group_by($group); 
        }
        $temp = $this->db->get();
        if($echo==1)
        {
            echo $this->db->last_query();exit;
        }
        switch ($result_way) {
            case 'row':
                $result=$temp->row();
                break;
            case 'row_array':
                $result=$temp->row_array();
                break;
            case 'count':
                $result=$temp->num_rows();
                break;
            default:
                $result=$temp->result_array();
                break;
        }
        return $result;
        //echo "<pre>";print_r($a);exit;
    }

	function select_custom($q, $is_res = 0) {

        $query = $this->db->query($q);

        if ($is_res == 1) {

            return $query;
        } else {

            return $query->result_array();
        }
    }
	
    function delete_entry($t,$w){        
        return $this->db->delete($t,$w); 
    }
	
	function checkemail($email){

		$this->db->where('email',$email);

		$query=$this->db->get('tbl_therapist');
		
		if($query->num_rows()>0){

			return true;

		}else{

			$this->db->where('email',$email);

			$query=$this->db->get('tbl_client');

			if($query->num_rows()>0){

				return true;

			}else{

				return false;

			}

		}

	}
	
	function admin_checkemail($email){

		$this->db->where('email',$email);

		$query=$this->db->get('tbl_admin');
		
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	function search($p){
        $result=array();
        $this->db->select($p['s']);
        $this->db->from("tbl_post");
        
        if($p['st'] != ''){
            $this->db->where('street',$p['st']);
        }
        if($p['c'] != ''){
            $this->db->and_like('city',$p['c']);
        }
		if($p['sta'] != ''){
            $this->db->and_like('state',$p['sta']);
        }
		if($p['zip'] != ''){
            $this->db->and_like('zipcode',$p['zip']);
        }
        /*if($p['localtionwise'] > 0){
           $this->db->having("distance <= ",$p['localtionwise']);
        }*/
        //$this->db->limit($p['limit'],$p['offset']);
        $temp = $this->db->get();
        $result=$temp->result_array();
        //echo $this->db->last_query();
        return $result;
    }
}
?>
