<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

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
	public function __construct() {
		parent::__construct();
		ini_set('session.cookie_httponly',1); 
		ini_set('session.use_only_cookies',1);  
		
	} 
		
	public function index() {
		echo "Welcome.";
	}
	
	/*crud area*/
	public function create(){
	
	}
	public function read(){
	
	}	
	public function update(){
	
	}	
	public function delete(){
	
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>