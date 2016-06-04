<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {
	
	private function institution($institutionData){	
			
		$institutionTypeName = $this->model_db->getInstitutionType($institutionData['institution_type_id']);
		if(empty($institutionTypeName)){
			return $this->badrequest();
		}
		
		$institutionCityName = $this->model_db->getCity($institutionData['city_id']);
		if(empty($institutionCityName)){
			return $this->badrequest();
		}
		
		$institutionDistrictName = $this->model_db->getDistrict($institutionCityName[0]['district_id']);
		if(empty($institutionDistrictName)){
			return $this->badrequest();
		}
		
		$institutionProvinceName = $this->model_db->getProvince($institutionDistrictName[0]['id_province']);
		if(empty($institutionProvinceName)){
			return $this->badrequest();
		}
		
		$categoriesLabel = $this->model_db->getCategoriesByInstitution($institutionData['id']);
		if(empty($categoriesLabel)){
			return $this->badrequest();
		}
		
		$data = array(
			'institution' => $institutionData,
			'institutionTypeName' => $institutionTypeName[0]['name'],
			'institutionCityName' => $institutionCityName[0]['name'],
			'institutionDistrictName' => $institutionDistrictName[0]['name'],
			'institutionProvinceName' => $institutionProvinceName[0]['name'],
			'categoriesLabel' => $categoriesLabel		
		);
		$this->load->view('site_page_institution_detail',$data);
	}
	
	public function __construct(){
		parent::__construct();		
		//libraries
		$this->load->library('session');
		$this->load->library('mapasoli');
				
		if($this->session->userdata('param')['site_online'] == 'FALSE' and $this->router->fetch_method() != 'siteoffline'){
			$this->session->sess_destroy();
			redirect('./siteoffline', 'refresh');
		}
		
		$this->mapasoli->init();
		
	}
			
	public function index()
	{
		$this->map();
	}
	
	public function map($value=null)
	{
		$data = array('value'=>$value);
		$this->load->view('site_page_map',$data);
	}
	
	public function search()
	{
		redirect('./?q='.$_GET['q'], 'refresh');
	}
	
	public function theproject()
	{		
		$data = array();
		$this->load->view('site_page_the_project',$data);
	}
	
	public function new_institution()
	{
		$data = array();
		$this->load->model('model_db');
		
		$provinces = $this->model_db->getProvinces();
		if(empty($provinces)){
			return $this->badrequest();
		}
		$data['provinces'] = $provinces;
		
		$institution_types = $this->model_db->getInstitutionTypes();
		if(empty($institution_types)){
			return $this->badrequest();
		}
		$data['institution_types'] = $institution_types;		
		
		$this->load->view('site_page_add_institution',$data);
	}
	
	public function save_institution(){
		$post = $this->input->post();
		if(empty($post)){
			return $this->badrequest();
		}
		$data = array('result' => $this->mapasoli->saveInstitution($post));
		$this->load->view('site_page_save_institution',$data);
	}
	
	public function institutionByCode($code=null)
	{
		if($code==null){
			return $this->badrequest();
		}
		
		$this->load->model('model_db');
		$result = $this->model_db->getInstitutionByCode($code);
		if(empty($result)){
			return $this->badrequest();
		}
		
		$this->institution($result[0]);
		
		
	}
	
	public function institutionByAlias($alias=null)
	{
		
		if($alias==null){
			return $this->badrequest();
		}
		
		$this->load->model('model_db');
		$result = $this->model_db->getInstitutionByAlias($alias);
		if(empty($result)){
			return $this->badrequest();
		}
		
		$this->institution($result[0]);
	}
	
	public function contactus($subject=null)
	{
		$data = array(
						'subject' => $subject
				);

		$this->load->view('site_page_contact_us',$data);
	}
	
	public function reportError()
	{
		$data = array(
						'subject' => $subject
				);

		$this->load->view('site_page_contact_us',$data);
	}
	
	public function sendForm(){
		$this->mapasoli->sendForm();
	}
	
	public function confirm($key=null)
	{
		if($key!=null){
			
			$data = array('result' => $this->mapasoli->confirmKey($key));			
			$this->load->view('site_page_mail_confirm',$data);
			
		}else{
			redirect('./', 'refresh');
		}
	}
	
	public function helpus()
	{
		$data = array();
		$this->load->view('site_page_help_us',$data);
	}
	
	public function help()
	{
		$this->load->view('site_page_help');
	}
	
	public function announcements()
	{
		if($this->mapasoli->showAnnouncement()){
			$this->load->view('site_page_announcement');
		}else{
			return $this->badrequest();
		}
	}
	
	public function siteoffline()
	{		
		$data = array();
		$this->load->view('site_page_maintenance',$data);
	}
	
	public function badrequest()
	{		
		$data = array();
		$this->load->view('site_page_404',$data);
	}
	
	public function download($filename=null)
	{
		
		if($filename!=null){
			$this->load->helper('download');
			
			if(strpos($filename,'.pdf') !== false){
				
				$this->output
					->set_content_type('application/pdf')
					->set_output(file_get_contents('resources/'.$filename));
				
			}else{
				force_download(base_url().'resources/'.$filename, NULL);
			}
			
		}else{
			$this->output
				->set_status_header('404');
		}

	}
}
