<?php

require(APPPATH."libraries/REST_Controller.php");
 
class Api extends REST_Controller {
		
	public function __construct(){
		parent::__construct();
		
		//load model:
		$this->load->model('model_restapi');
		
		//load helpers
		$this->load->helper('url');
		
	}
	
	function categories_get(){
		//http://localhost:7080/mapasoli/api/categories
		
		$where = array();
		if($this->get('id')!=null){
			$where = array('id'=>$this->get('id'));
		}
				
		$this->response($this->model_restapi->getCategories($where), 200);
	}
	
	function institutionstype_get(){
		
		$where = array();
		
		$this->response($this->model_restapi->getInstitutionsType($where), 200);
	}
	
	function provinces_get(){
		
		$where = array();
		
		if($this->get('id')!=null){
			$where = array('id'=>$this->get('id'));
		}
		
		$this->response($this->model_restapi->getProvinces($where), 200);
	}
	
	function districts_get(){
		
		$where = array();
		
		if($this->get('id')!=null){
			$where = array('id'=>$this->get('id'));
		}
		
		if($this->get('id_province')!=null){
			$where = array('id_province'=>$this->get('id_province'));
		}
		
		$this->response($this->model_restapi->getDistricts($where), 200);
	}
	
	function cities_get(){
		
		$where = array();
		
		if($this->get('id')!=null){
			$where = array('id'=>$this->get('id'));
		}
		
		if($this->get('district_id')!=null){
			$where = array('district_id'=>$this->get('district_id'));
		}
		
		$this->response($this->model_restapi->getCities($where), 200);
	}
	
	function institutions_get(){
		
		$where = array();
		if($this->get('id')!=null){
			$where = array('MI.id' => $this->get('id'));
		}
		
		$this->response($this->model_restapi->getInstitutions($where), 200);			
	}
	
	function markers_get(){
		
		$where = array();
		
		if($this->get('id')!=null){
			$where = array('MI.id'=>$this->get('id'));
		}
		
		if($this->get('alias')!=null){
			$where = array('MI.alias'=>$this->get('alias'));
		}
		
		if($this->get('category')!=null){
			$where = array('MCT.parent_id'=>$this->get('category'));
		}
		
		$match = '';
		if($this->get('search')!=null){
			$match = urldecode($this->get('search'));
		}elseif($this->get('q')!=null){
			$match = urldecode($this->get('q'));
		}
		
		if($match!=''){
			$this->response($this->model_restapi->searchMarkers($match), 200);
		}else{
			$this->response($this->model_restapi->getMarkers($where), 200);
		}	
	}
 
}
