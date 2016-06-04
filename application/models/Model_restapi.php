<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_restapi extends CI_Model{	
	
	public function getCategories($where){
		
		$fields = 'id,caption,class,icon';
		
		$where = array_merge($where,array('deleted_by' => null,'depth'=>'1', 'hidden'=>0));
		
		$this->db->select($fields);
		
		$this->db->where($where);
		
		$this->db->order_by('caption', 'asc');
		
		$query = $this->db->get('category_tree');
	
		return $query->result_array();
	}
	
	public function getInstitutionsType($where){
		
		$fields = 'id,name';
		
		$where = array_merge($where,array('deleted_by' => null));
		
		$this->db->select($fields);
		
		$this->db->where($where);
		
		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get('institution_type');
	
		return $query->result_array();
	}
	
	public function getProvinces($where){
		
		$fields = 'id,name';
		
		$where = array_merge($where,array('deleted_by' => null));
		
		$this->db->select($fields);
		
		$this->db->where($where);
		
		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get('province');
	
		return $query->result_array();
	}
	
	public function getDistricts($where){
		
		$fields = 'id,name';
		
		$where = array_merge($where,array('deleted_by' => null));
		
		$this->db->select($fields);
		
		$this->db->where($where);
		
		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get('district');
	
		return $query->result_array();
	}
	
	public function getCities($where){
		
		$fields = 'id,name';
		
		$where = array_merge($where,array('deleted_by' => null));
		
		$this->db->select($fields);
		
		$this->db->where($where);
		
		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get('city');
	
		return $query->result_array();
	}
	
	public function getInstitutions($where){
		
		$fields = 'MI.id, code,MI.name,latitude,longitude,street_name,street_number,floor_depart,zip_code,between_street_1,between_street_2,city.name as "city",phone,site_url,email,twitter,facebook,institution_type.name as "type",description,MCT.parent_id as "category", MCTPARENT.icon';
		
		$where = array_merge($where,array(' MI.deleted_by' => null,'MCT.deleted_by'=>null,'MCT.hidden'=>0,'MCTPARENT.hidden'=>0,'MI.status'=>'A'));
		
		$this->db->select($fields);
		$this->db->from('institution as MI');
		$this->db->join('institution_type', 'institution_type.id = MI.institution_type_id', 'inner');
		$this->db->join('city', 'city.id = MI.city_id', 'inner');
		$this->db->join('mapasoli_institution_category_rel as MIC', 'MI.id = MIC.institution_id', 'inner');
		$this->db->join('mapasoli_category_tree as MCT', 'MIC.category_tree_id = MCT.id', 'inner');
		$this->db->join('mapasoli_category_tree as MCTPARENT', 'MCT.parent_id = MCTPARENT.id', 'inner');
		
		$this->db->where($where);
		
		$this->db->order_by('id', 'asc');
		
		$query = $this->db->get();
	
		return $query->result_array();
	}
	
	public function searchMarkers($match){
		
		$fields = 'MI.id, MI.alias, code,MI.name,latitude,longitude,street_name,street_number,floor_dept,zip_code,between_street_1,between_street_2,CI.name as "city",phone,site_url,email,twitter,facebook,institution_type.name as "type",description,MCT.parent_id as "category", MCTPARENT.caption as "cat_caption", MCTPARENT.class as "cat_class" ,MCTPARENT.icon';
		
		$where = ('( MI.deleted_by IS NULL AND MCT.deleted_by IS NULL AND MCT.hidden = 0 AND MCTPARENT.hidden = 0 AND MI.status = "A" )');
		
		$this->db->distinct();
		$this->db->select($fields);
		$this->db->from('institution as MI');
		$this->db->join('institution_type', 'institution_type.id = MI.institution_type_id', 'inner');
		$this->db->join('city as CI', 'CI.id = MI.city_id', 'inner');
		$this->db->join('mapasoli_institution_category_rel as MIC', 'MI.id = MIC.institution_id', 'inner');
		$this->db->join('mapasoli_category_tree as MCT', 'MIC.category_tree_id = MCT.id', 'inner');
		$this->db->join('mapasoli_category_tree as MCTPARENT', 'MCT.parent_id = MCTPARENT.id', 'inner');
					
		$this->db->group_start();
		$this->db->like('upper( MI.name )',strtoupper ($match));
		$this->db->or_like('upper(street_name )',strtoupper ($match));
		$this->db->or_like('upper(street_name )',strtoupper ($match));
		$this->db->or_like('upper( between_street_1 )',strtoupper ($match));
		$this->db->or_like('upper( between_street_2 )',strtoupper ($match));
		$this->db->or_like('upper( CI.name )',strtoupper ($match));
		$this->db->or_like('upper( site_url )',strtoupper ($match));
		$this->db->or_like('upper( twitter )',strtoupper ($match));
		$this->db->or_like('upper( facebook )',strtoupper ($match));
		$this->db->or_like('upper( description )',strtoupper ($match));
		$this->db->or_like('upper( MCT.name )',strtoupper ($match));
		$this->db->or_like('upper( MCTPARENT.caption )',strtoupper ($match));
		$this->db->group_end();
		
		$this->db->where($where);
		
		$this->db->order_by('MI.name', 'asc');
		
		$query = $this->db->get();
	
		return $query->result_array();
	}
		
	/**
     * Return markers from DB if exist
     */
	public function getMarkers($where){
				
		$where = array_merge($where,array(' MI.deleted_by' => null,'MCT.deleted_by'=>null,'MCT.hidden'=>0,'MCTPARENT.hidden'=>0,'MI.status'=>'A'));
				
		$this->db->distinct();
		$this->db->select("MI.id, MI.alias, MI.name, code, street_name, street_number, floor_dept, MI.description, MI.latitude, MI.longitude, MCT.parent_id as 'category', MIT.name as 'type', MSS.name as 'source_name', MSS.site_url as 'source_site_url', MSS.description as 'source_description', MCTPARENT.icon");
		$this->db->from('institution as MI');
		$this->db->join('institution_category_rel as MIC', 'MI.id = MIC.institution_id');
		$this->db->join('source_system as MSS', 'MSS.id = MI.source_id');
		$this->db->join('category_tree as MCT', 'MIC.category_tree_id = MCT.id');
		$this->db->join('institution_type as MIT', 'MIT.id = MI.institution_type_id', 'inner');
		$this->db->join('category_tree as MCTPARENT', 'MCT.parent_id = MCTPARENT.id');
		
		$this->db->where($where);
		
		$query = $this->db->get();
		
		return $query->result();
	}
}