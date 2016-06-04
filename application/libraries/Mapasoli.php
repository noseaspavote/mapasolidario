<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mapasoli class
 * Custom Lib for the site
 *
 * @author    @agvago
 */
class Mapasoli {
    
    /**
     * Js and css scripts versioning
     */
    const SCRIPT_VER = '1.3';
    const SCRIPT_MIN = '';
    
    /**
     * Contact Form subjects
     */
    private $contactSubjects = array(
							'ayudar' => 'Quiero ayudar',
							'desarrollar' => 'Quiero desarrollar',
							'reportar-error' => 'Reportar un error',
							'otros' => 'Otro asunto'
						);
						
	/**
     * Contact Institution Form subjects
     */
    private $contactInstitutionSubjects = array(
							'ayudar' => 'Quiero ayudar',
							'donar' => 'Quiero Donar',
							'otros' => 'Otro asunto'
						);
						
	/**
     * Form Types
     */
	 const FROM_TYPE_CONTACT = 'contact';
	 const FROM_TYPE_ADD_INSTITUTION = 'add-institution';
	 const FROM_TYPE_CONTACT_INSTITUTION = 'contact-institution';
    
	/**
     * Codeigniter instance
     */
    private $_CI;
	
	
	private function _sessionAdd($key,$data){
		$this->_CI->session->set_userdata($key,$data); 
    }
    
    private function _sessionGet($key){
        return $this->_CI->session->userdata($key);
    }
	
	/**
     * Generates random key with letters and numbers
     */
	private function generateRandomString($length = 100) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
    
    private function googleCaptchaResponse($response){
		$secret = $this->mapasoli_config['google_captcha_secret_key'];
		$google_url="https://www.google.com/recaptcha/api/siteverify";
		$url = $google_url . "?secret=" . $secret . "&response=" . $response . "&remoteip=" . $_SERVER['REMOTE_ADDR'];

		$google_response = json_decode(file_get_contents($url));
		
		return $google_response->success;
	} 
	
	private function loadMailConfig(){
		$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => $this->mapasoli_config['mail_smpt_host'],
				'smtp_port' => $this->mapasoli_config['mail_smpt_port'],
				'smtp_user' => $this->mapasoli_config['mail_smpt_user'],
				'smtp_pass' => $this->mapasoli_config['mail_smpt_pass'],
				'smtp_timeout' => '4',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'wordwrap' => TRUE
			);
		
		$this->_CI->load->library('email', $config);
	}    
	
	private function sendContact($email, $name, $subjectId, $message, $gRecaptchaResponse){
        $googleResponse = $this->googleCaptchaResponse($gRecaptchaResponse);
         
		if($googleResponse){
			$options = array(
						'name' => $name,
						'message' => $message
					);
						
			$this->loadMailConfig();
			$this->_CI->email
							->set_newline("\r\n")
							->reply_to($email, $name)
							->from($this->mapasoli_config['mail_from_adress'], $this->mapasoli_config['mail_from_name'])
							->subject('Contacto desde MapaSolidario - ' .  $this->getSubject($subjectId))
							->to(explode(';',$this->mapasoli_config['mail_contact_to']))	
							->message($this->_CI->load->view('mail_contactus',$options, TRUE));
			
			$this->_CI->output
						->set_status_header('200')
						->set_content_type('application/json')
						->set_output($this->_CI->email->send());
			
		}else{
			$this->_CI->output
					->set_status_header('403')
					->set_content_type('application/json');
		}
    }
	
	private function sendConfirmMailToInstitution($institution_email, $institution_name, $suscripter_name, $suscripter_email, $confirm_key){
		$options = array(
						'institution_name' => $institution_name,
						'suscripter_name' => $suscripter_name,
						'suscripter_email' => $suscripter_email,
						'confirm_key' => $confirm_key
					);
		
		$this->loadMailConfig();
			$this->_CI->email
							->set_newline("\r\n")
							->reply_to($this->mapasoli_config['mail_from_adress'], $this->mapasoli_config['mail_from_name'])
							->from($this->mapasoli_config['mail_from_adress'], $this->mapasoli_config['mail_from_name'])
							->subject('#MapaSolidario - Confirmación de correo electrónico')
							->to($institution_email)	
							->message($this->_CI->load->view('mail_institution_confirm_link',$options, TRUE));
							
		return $this->_CI->email->send();
	}
	
	private function sendConfirmMailToSuscriptor($suscriptor_name, $suscriptor_email, $confirm_key){
		$options = array(
						'suscriptor_name' => $suscriptor_name,
						'confirm_key' => $confirm_key
					);
		
		$this->loadMailConfig();
			$this->_CI->email
							->set_newline("\r\n")
							->reply_to($this->mapasoli_config['mail_from_adress'], $this->mapasoli_config['mail_from_name'])
							->from($this->mapasoli_config['mail_from_adress'], $this->mapasoli_config['mail_from_name'])
							->subject('#MapaSolidario - Confirmación de correo electrónico')
							->to($suscriptor_email)	
							->message($this->_CI->load->view('mail_suscriptor_confirm_link',$options, TRUE));
							
		return $this->_CI->email->send();
	}
	
	private function sendMessageToInstitution($alias, $email, $name, $subjectId, $message, $gRecaptchaResponse){
        $googleResponse = $this->googleCaptchaResponse($gRecaptchaResponse);
         
		if($googleResponse){
			
       		// Load model
        	$this->_CI->load->model('model_db');
			$institution = $this->_CI->model_db->getInstitutionByAlias($alias);
			
			if(empty($institution)){
				$this->_CI->output
					->set_status_header('503')
					->set_content_type('application/json');
			}
					
			$options = array(
						'name' => $name,
						'email' => $email, 
						'message' => $message
					);

			//if environment = production, then send to the institucion
			//if not, then send to mapasoli contact mail 
			if($this->isProduction()){
				$institutionMail = $institution[0]['email'];
			}else{
				$institutionMail = $this->mapasoli_config['mail_contact_to'];
			}
						
			$this->loadMailConfig();
			$this->_CI->email
							->set_newline("\r\n")
							->reply_to($email, $name)
							->from($this->mapasoli_config['mail_from_adress'], $this->mapasoli_config['mail_from_name'])
							->subject('Mensaje desde el #MapaSolidario - ' .  $this->getInstitutionSubject($subjectId))
							->to($institutionMail)	
							->message($this->_CI->load->view('mail_institution_message',$options, TRUE));
							
			//log message
			$this->_CI->model_db->logMessage($institution[0]['id'], $name, $email, $subjectId, $message);
			
			$this->_CI->output
						->set_status_header('200')
						->set_content_type('application/json')
						->set_output($this->_CI->email->send());
			
		}else{
			$this->_CI->output
					->set_status_header('403')
					->set_content_type('application/json');
		}
    }
	
	private function newsletterSubscriptionAdd($email, $newsletter){
		if($newsletter == 'true'){
			$this->_CI->load->model('model_db');
			$insertId = $this->_CI->model_db->newsletterSuscriptorAdd($email, $this->generateRandomString());
		}
	}
	
	public function isProduction(){
		if(ENVIRONMENT == 'production')
			return true;
		return false;
	}

    public function __construct()
    {
        // Get the CodeIgniter reference
        $this->_CI = &get_instance();
		$this->_CI->config->load('mapasoli');
		$this->mapasoli_config = $this->_CI->config->item('mapasoli');
    }
	
	public function init(){
		//$this->_CI->session->sess_destroy();
		if(!$this->_CI->session->userdata('init')){
			$newdata = array(
							'init' => true,
							'showAnnouncementOnLoad'  => true,
							'announcementContent' => array()
						);
			$this->_CI->session->set_userdata($newdata); 
		}		
	}
    
    public function scriptVer(){
        return self::SCRIPT_VER;
    }
	
	public function scriptMin(){
		return self::SCRIPT_MIN;
	}
    
    public function getSubject($subjectId){
        return $this->contactSubjects[$subjectId];
    }
    
    public function getSubjects(){
        return $this->contactSubjects;
    }
	
	public function getInstitutionSubjects(){
        return $this->contactInstitutionSubjects;
    }
	
	public function getInstitutionSubject($subjectId){
        return $this->contactInstitutionSubjects[$subjectId];
    }
	
	public function googleCaptchaSiteKey(){
		return $this->mapasoli_config['google_captcha_site_key'];
	}
    	
	public function sendForm(){
		
		$formType = $this->_CI->input->post('formType', TRUE);
		
		switch ($formType) {
            case self::FROM_TYPE_CONTACT:
			
				$email = $this->_CI->input->post('email', TRUE);
				$name = $this->_CI->input->post('name', TRUE);
				$subject = $this->_CI->input->post('subject', TRUE);
				$message = $this->_CI->input->post('message', TRUE);
				$newsletter = $this->_CI->input->post('newsletter', TRUE);
				$gRecaptchaResponse = $this->_CI->input->post('g-recaptcha-response', TRUE);
				
				if($this->_CI->input->post('info')){
					$message = urldecode($this->_CI->input->post('info')) . '<br>' . $message;	
				}
				
				$this->newsletterSubscriptionAdd($email, $newsletter);
                $this->sendContact($email, $name, $subject, $message, $gRecaptchaResponse);				
                break;
			case self::FROM_TYPE_CONTACT_INSTITUTION:
				$alias = $this->_CI->input->post('toInstitution', TRUE);
				$email = $this->_CI->input->post('email', TRUE);
				$name = $this->_CI->input->post('name', TRUE);
				$subject = $this->_CI->input->post('subject', TRUE);
				$message = $this->_CI->input->post('message', TRUE);
				$newsletter = $this->_CI->input->post('newsletter', TRUE);
				$gRecaptchaResponse = $this->_CI->input->post('g-recaptcha-response', TRUE);
			
				$this->newsletterSubscriptionAdd($email, $newsletter);
                $this->sendMessageToInstitution($alias, $email, $name, $subject, $message, $gRecaptchaResponse);				
                break;
				
            default:
                $this->output
					->set_status_header('501') /* Not Implemented */
					->set_content_type('application/json');
        }	
	}
	
	public function saveInstitution($post){
		 $googleResponse = $this->googleCaptchaResponse($post['g-recaptcha-response']);
		 //$googleResponse = true;
         
		if($googleResponse){
			$suscriptor_type = $post['suscriptor_type'];
			$suscriptor_name = $post['suscriptor_name'];
			$suscriptor_email = $post['suscriptor_email'];
			
			//removing elements I don't want to insert in DB
			unset($post['g-recaptcha-response']);
			unset($post['alias_check']);
			unset($post['province_id']);
			unset($post['district_id']);
			unset($post['email_check']);
			unset($post['suscriptor_email_check']);
			unset($post['suscriptor_type']);
			unset($post['suscriptor_name']);
			unset($post['suscriptor_email']);	
			
			$post['created_by'] = 'system';
			$post['last_updated_by'] = 'system';
			$post['status'] = 'W';
			
			$this->_CI->load->model('model_db');
			$insertId = $this->_CI->model_db->insertInstitution($post);
			$confirm_key = $this->generateRandomString();
			
			$suscriptorData = array(
								'name' => $suscriptor_name,
								'email' => $suscriptor_email,
								'type' => $suscriptor_type,
								'key' => $confirm_key,
								'key_expiration_date' => date('Y-m-d H:i:s', strtotime("+3 days")), //key expires in 3 days date('Y-m-d H:i:s');
								'institution_id' => $insertId
								);
								
			$this->_CI->model_db->insertSuscriptor($suscriptorData);
			
			//Sending mail to suscriptor
			return $this->sendConfirmMailToSuscriptor($suscriptor_name, $suscriptor_email, $confirm_key);
		}else{
			return false;
		}
	}
	
	public function confirmKey($key){
		$this->_CI->load->model('model_db');
		$suscripter = $this->_CI->model_db->getSuscriptor($key);
		
		if(empty($suscripter)){
			return false;
		}
		
		if($suscripter[0]['type']=='institution'){			
			$this->_CI->model_db->markSuscriptorUsed($suscripter[0]['id']);
			$this->_CI->model_db->changeInstitutionStatusP($suscripter[0]['institution_id']);
			return true;
		}else{
			$institution = $this->_CI->model_db->getInstitutionById($suscripter[0]['institution_id']);
			if(empty($institution)){
				return false;
			}
			
			$confirm_key = $this->generateRandomString();
			
			$suscriptorData = array(
								'name' => $suscripter[0]['name'],
								'email' => $institution[0]['email'],
								'type' => 'institution',
								'key' => $confirm_key,
								'key_expiration_date' => date('Y-m-d H:i:s', strtotime("+3 days")), //key expires in 3 days date('Y-m-d H:i:s');
								'institution_id' => $suscripter[0]['institution_id']
								);
								
			$this->_CI->model_db->insertSuscriptor($suscriptorData);
			$this->_CI->model_db->markSuscriptorUsed($suscripter[0]['id']);
			return $this->sendConfirmMailToInstitution($institution[0]['email'], $institution[0]['name'], $suscripter[0]['name'], $suscripter[0]['email'], $confirm_key);
		}
		
		
		
		return true;
	}
		
	public function showAnnouncement(){
		$content = $this->_sessionGet('announcementContent');
				
		if(empty($content)){
        	$this->_CI->load->model('model_db');
			$result = $this->_CI->model_db->getAnnoucement();
			if(!empty($result)){
				$content = array(
								'title' => $result[0]['title'],
								'content' => $result[0]['content'],
								'expiration_date' => $result[0]['expiration_date']	
							);
				$this->_sessionAdd('announcementContent',$content);
				return true;				
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
	
	public function getAnnouncementContent(){
		return $this->_sessionGet('announcementContent')['content'];
	}
	
	public function getAnnouncementTitle(){
		return $this->_sessionGet('announcementContent')['title'];
	}
	
	public function showAnnouncementOnLoad(){
		if($this->_sessionGet('showAnnouncementOnLoad')==true){
			$this->_sessionAdd('showAnnouncementOnLoad',false);
			return true;
		}
		return false;
	} 
}
