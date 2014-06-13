<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Class*/
class Upload extends CI_Controller {
	
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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	/*Initialize class*/
	public function __construct() {
		parent::__construct();
		ini_set('session.cookie_httponly',1); 
		ini_set('session.use_only_cookies',1);  
	}
	
	public function index() {
	
		/*Check file exist and delete file*/
		$file = FCPATH.'assets/uploads/'.date("Ymd").'.csv';
		if(file_exists($file)){
			unlink($file);
		}
		
		$this->load->view('upload_form', array('error' => ' ' ));
	}
	
	/*Upload data*/
	public function do_upload(){
		
		/*Set Config for upload library*/
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'csv';
		$config['file_name'] = date("Ymd").'.csv';

		/*Call library upload*/
		$this->load->library('upload', $config);
		
		if ( ! ($this->upload->do_upload())){
			/*Error upload area*/
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}else{
			/*Success upload area*/
			$data = array('upload_data' => $this->upload->data());
			$res = $this->upload->data();
			header("location: ".base_url()."result/create/1/".$res['orig_name']);	
		}
	}
}
?>