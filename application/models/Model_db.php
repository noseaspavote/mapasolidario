<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_DB extends CI_Model{		
	public function getInstitutionByAlias($alias){
		$where = array(
					'deleted_by' => null,
					'status'=>'A',
					'alias' => strtolower($alias)
					);
		
		$this->db->select();
		$this->db->from('institution');
		
		$this->db->where($where);
		
		$this->db->order_by('id', 'asc');
		
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	public function getInstitutionByCode($code){
		$where = array(
					'deleted_by' => null,
					'status'=>'A',
					'code' => strtolower($code)
					);
		
		$this->db->select();
		$this->db->from('institution');
		
		$this->db->where($where);
		
		$this->db->order_by('id', 'asc');
		
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	
	public function getInstitutionById($id){
		$where = array(
					'deleted_by' => null,
					'status'=>'A',
					'id' => $id
					);
		
		$this->db->select();
		$this->db->from('institution');
		$this->db->where($where);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	public function getInstitutionType($id){
		$where = array(
					'id' => $id
					);
		
		$this->db->select();
		$this->db->from('institution_type');
		
		$this->db->where($where);
				
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	public function getInstitutionTypes(){
		$this->db->select();
		$this->db->from('institution_type');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCity($id){
		$where = array(
					'id' => $id
					);
		$this->db->select();
		$this->db->from('city');
		$this->db->where($where);	
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	public function getDistrict($id){
		$where = array(
					'id' => $id
					);
		$this->db->select();
		$this->db->from('district');
		$this->db->where($where);	
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	public function getProvince($id){
		$where = array(
					'id' => $id
					);
		$this->db->select();
		$this->db->from('province');
		$this->db->where($where);	
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	public function getProvinces(){
		$this->db->select();
		$this->db->from('province');	
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}
		
	public function getCategoriesByInstitution($id){
		
		$this->db->select('MCTPARENT.*');
		$this->db->from('category_tree as MCTPARENT');
		$this->db->join('category_tree as MCT', 'MCT.parent_id = MCTPARENT.id', 'inner');
		$this->db->join('institution_category_rel as MICR', 'MICR.category_tree_id = MCT.id', 'inner');
		
		$this->db->where(array('MICR.institution_id' => $id, 'MCTPARENT.depth' =>1));
		
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	public function logMessage($id, $name, $email, $subject, $message){
		$data = array(
					'from_name' => $name,
					'from_email' => $email,
					'subject' => $subject,
					'message' => $message,
					'to_institution_id' => $id
					);
		
		$this->db->insert('message_log', $data); 
		return $this->db->insert_id();
	}
	
	public function logVisiter($data){		
		
		$this->db->select();
		$this->db->from('visiter_log');
		$this->db->where(array('ip' => $data->ip));
		$query = $this->db->get();
	
		if(empty($query->result_array())){
			$this->db->insert('visiter_log', $data); 
		}
	}
	
	public function insertInstitution($data){
		$this->db->insert('institution', $data);
		return $this->db->insert_id();
	}
	
	public function insertSuscriptor($data){
		$this->db->insert('suscriptor', $data);
		return $this->db->insert_id();
	}
	
	public function getAnnoucement(){			
		$this->db->order_by('expiration_date', 'asc');
		$this->db->where('expiration_date >= NOW()');	
		$query = $this->db->get('announcement');
		return $query->result_array();
	}
	
	public function getSuscriptor($key){		
		$this->db->where(array('key' => $key));
		$this->db->where('used = 0');	
		$this->db->where('key_expiration_date >= NOW()');
		$query = $this->db->get('suscriptor');
		return $query->result_array();
	}
	
	public function markSuscriptorUsed($id){
		$data = array(
               'used' => '1'
            );
		$this->db->where('id', $id);
		$this->db->update('suscriptor', $data); 
	}
	
	public function getInstitutions($id=null){
		if($id==null){
			$where = array();
		}else{
			$where = array('id' => $id);
		}
		
		$this->db->select();
		$this->db->from('institution');
		$this->db->where($where);
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function changeInstitutionStatusP($id){
		$data = array(
               'status' => 'P'
            );
		$this->db->where('id', $id);
		$this->db->update('institution', $data); 
	}
	
	public function newsletterSuscriptorAdd($email,$key){		
		$data = array(
					'email' => $email,
					'key' => $key
				);
		$insert_query = $this->db->insert_string('newsletter_suscriptor', $data);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$this->db->query($insert_query);
	}
}