<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Class*/
class Result extends CI_Controller {

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
		$this->load->model('game_type_class');
		$this->load->model('result_class');
		$this->load->model('six_digit_zero_nine_class');
	} 
		
	public function index() {
		
	}
	
	/*Crud area*/
	
	public function create($intUploaded = null, $name = null) {
		
		/*Get request*/
		$request = $this->input->server('REQUEST_METHOD');
		
		if($request=="POST"){
			/*Post area*/
			$post = $this->input->post();

			/*Test combinations*/
			switch($post['intLottoType']){
				case 17:
					$chk = $this->chk_gl($post['1']);
				break;
				case 1:
					$chk = $this->chk_sl($post['1']);
				break;
				case 2:
					$chk = $this->chk_ml($post['1']);
				break;		
				case 13:
					$chk = $this->chk_l($post['1']);
				break;	
				case 5:
					$chk = $this->chk_sd($post['1']);
				break;				
				default:
					
				break;
			}
			
			/*Check if data exist*/
			$data = array('intLottoType'=>$post['intLottoType'],'dateDrawDate'=>$post['2']);
			$found = 1;
			if($chk==1){			
				$found = $this->result_class->read(5,$data);
			} else {
				$found = $this->result_class->read(2,$data);
			}
			if($found==0){
				/*Not found area*/
				
				/*Insert data*/
				if($chk==1){
					$res = $this->result_class->create(1,$post);
				} else {
					$res = $this->result_class->create(0,$post);
				}
				
				/*Cache result of 6 digit draws*/
				if($post['intLottoType']*1==5){
					
					/*get numbers*/
					$digit = explode('-',$post['1']);
					
					/*update cache area*/
					/*1st digit*/
					$data = array('intNumber'=>$digit['0']);
					$found =  $this->six_digit_zero_nine_class->read(2, $data);
					if($found!=0){
						$where = array('intNumber'=>$digit['0']);
						$set = array('intOne'=>$found['intOne']*1+1);
						
						$this->six_digit_zero_nine_class->update($where, $set);
					} else {
						
					}
					/*2nd digit*/
					$data = array('intNumber'=>$digit['1']);
					$found =  $this->six_digit_zero_nine_class->read(2, $data);
					if($found!=0){
						$where = array('intNumber'=>$digit['1']);
						$set = array('intTwo'=>$found['intTwo']*1+1);
						
						$this->six_digit_zero_nine_class->update($where, $set);
					} else {
						
					}					
					/*3rd digit*/
					$data = array('intNumber'=>$digit['2']);
					$found =  $this->six_digit_zero_nine_class->read(2, $data);
					if($found!=0){
						$where = array('intNumber'=>$digit['2']);
						$set = array('intThree'=>$found['intThree']*1+1);
						
						$this->six_digit_zero_nine_class->update($where, $set);
					} else {
						
					}	
					/*4th digit*/
					$data = array('intNumber'=>$digit['3']);
					$found =  $this->six_digit_zero_nine_class->read(2, $data);
					if($found!=0){
						$where = array('intNumber'=>$digit['3']);
						$set = array('intFour'=>$found['intFour']*1+1);
						
						$this->six_digit_zero_nine_class->update($where, $set);
					} else {
						
					}	
					/*5th digit*/
					$data = array('intNumber'=>$digit['4']);
					$found =  $this->six_digit_zero_nine_class->read(2, $data);
					if($found!=0){
						$where = array('intNumber'=>$digit['4']);
						$set = array('intFive'=>$found['intFive']*1+1);
						
						$this->six_digit_zero_nine_class->update($where, $set);
					} else {
						
					}	
					/*6th digit*/
					$data = array('intNumber'=>$digit['5']);
					$found =  $this->six_digit_zero_nine_class->read(2, $data);
					if($found!=0){
						$where = array('intNumber'=>$digit['5']);
						$set = array('intSix'=>$found['intSix']*1+1);
						
						$this->six_digit_zero_nine_class->update($where, $set);
					} else {
						
					}					
				}
				echo json_encode($res);
			} else {
			
				/*Found area*/
				echo 0;
			}
		} else {
			/*Check if file is uploaded*/
			if($intUploaded==1){
				$this->view_uploaded_result($name);
			} else {
			
				$this->upload_form();
			}
		}
	}
	
	public function read($gameType = null, $date_to = null, $date_from = null, $output = null){
		$data = array('intLottoType'=>$gameType,
					'dateDrawDate_to'=>$date_to,
					'dateDrawDate_from'=>$date_from
					);
		$res = $this->result_class->read(4,$data);
		$this->output($res, $output);
	}	
	
	public function update(){
	
	}
	
	public function delete(){
	
	}
	
	/*Private function area*/

	private function upload_form(){
		/*Redirect to uploader*/
		header("location: ".base_url()."upload");	
	}
	
	private function view_uploaded_result($name = null){
		
		/*Get game type*/
		$data['result'] = $this->game_type_class->read(0);		
		/*Check if file name*/
		if(isset($name)){
			/*Get CSV*/
			$data['csv'] = $this->read_csv($name);
		} else {
			$data['csv'] = 0;
		}
		$this->load->view("create_result",$data);
	}
	
	/*read CSV file*/
	private function read_csv($name){
		$res = 0;
		$row=0;
		/*Check if file exist*/
		if(file_exists(FCPATH.'assets/uploads/'.$name)){
			
			/*Open file*/
			if (($handle = fopen(FCPATH.'assets/uploads/'.$name, "r")) !== FALSE) {
				/*Set array variable*/
				$res = array();
				/*Get data from CSV*/
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					
					$num = count($data);
					$row++;
					for ($c=0; $c < $num; $c++) {
						$res[$row][$c] =  $data[$c];			
					}
				}
				fclose($handle);
			}	
		}
		return $res;
	}
	/*Output data*/
	private function output($res=null, $output=null){
	
		$data['res_obj']=$res;
		/*Choose output*/
		if($output=="json"){
			$this->load->view("view_json.php", $data);
		} else {
			echo json_encode($res);
		}
	}	
	private function chk_gl($num=null){
		$list = explode('-',$num);
		$c = count($list);
		$ret = 0;
		if($c<6){
			$ret = 1;
		} else {
			if($list[0] > 55){
				$ret = 1;
			}
			if($list[1] > 55){
				$ret = 1;
			}	
			if($list[2] > 55){
				$ret = 1;
			}		
			if($list[3] > 55){
				$ret = 1;
			}		
			if($list[4] > 55){
				$ret = 1;
			}		
			if($list[5] > 55){
				$ret = 1;
			}		
		}
		return $ret;
	}
	private function chk_sl($num=null){
		$list = explode('-',$num);
		$ret = 0;
		$c = count($list);
		$ret = 0;
		if($c<6){
			$ret = 1;
		} else {		
			if($list[0] > 49){
				$ret = 1;
			}
			if($list[1] > 49){
				$ret = 1;
			}	
			if($list[2] > 49){
				$ret = 1;
			}		
			if($list[3] > 49){
				$ret = 1;
			}		
			if($list[4] > 49){
				$ret = 1;
			}		
			if($list[5] > 49){
				$ret = 1;
			}		
		}
		return $ret;
	}	
	private function chk_ml($num=null){
		$list = explode('-',$num);
		$ret = 0;
		$c = count($list);
		$ret = 0;
		if($c<6){
			$ret = 1;
		} else {		
			if($list[0] > 45){
				$ret = 1;
			}
			if($list[1] > 45){
				$ret = 1;
			}	
			if($list[2] > 45){
				$ret = 1;
			}		
			if($list[3] > 45){
				$ret = 1;
			}		
			if($list[4] > 45){
				$ret = 1;
			}		
			if($list[5] > 45){
				$ret = 1;
			}		
		}
		return $ret;
	}	
	private function chk_l($num=null){
		$list = explode('-',$num);
		$ret = 0;
		$c = count($list);
		$ret = 0;
		if($c<6){
			$ret = 1;
		} else {		
			if($list[0] > 42){
				$ret = 1;
			}
			if($list[1] > 42){
				$ret = 1;
			}	
			if($list[2] > 42){
				$ret = 1;
			}		
			if($list[3] > 42){
				$ret = 1;
			}		
			if($list[4] > 42){
				$ret = 1;
			}		
			if($list[5] > 42){
				$ret = 1;
			}	
		}		
		return $ret;
	}		
	private function chk_sd($num=null){
		$list = explode('-',$num);
		$ret = 0;
		$c = count($list);
		$ret = 0;
		if($c<6){
			$ret = 1;
		} else {		
			if($list[0] > 9){
				$ret = 1;
			}
			if($list[1] > 9){
				$ret = 1;
			}	
			if($list[2] > 9){
				$ret = 1;
			}		
			if($list[3] > 9){
				$ret = 1;
			}		
			if($list[4] > 9){
				$ret = 1;
			}		
			if($list[5] > 9){
				$ret = 1;
			}	
		}		
		return $ret;
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>