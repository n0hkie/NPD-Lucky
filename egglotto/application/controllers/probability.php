<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Class*/
class Probability extends CI_Controller {

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
		$this->load->model('result_class');
	} 
		
	public function index() {
		$this->error_handler("No method.","");
	}
	
	/*Crud area*/
	public function create(){
	
	}
	
	public function read($gameType=null, $intLottoType = null, $strNumber = null, $output = null, $intIsSingle = null){
		/*Check game type*/
		switch($gameType){
			case "r6":
				$this->six_digit_logic($intLottoType, $strNumber, $output, "r6", $intIsSingle);
			break;
			case "c6":
				$this->six_digit_logic($intLottoType, $strNumber, $output, "c6");
			break;
			default:
				$msg = "No game type.";
				$this->error_handler($msg, $output);
			break;
		}
	}	
	
	public function update(){
	
	}
	
	public function delete(){
	
	}
	
	/*Private function area*/

	private function six_digit_logic($intLottoType = null, $strNumber = null, $output = null, $strType = null, $intIsSingle = null){
		
		/*Default*/
		$res["status"] = -1;
		$res["msg"] = "Error";
		
		
		/*String to array to get each number*/
		if(!(isset($strNumber))){
			/*if null area*/
			$strNumber = "a-a";
		}
		
		echo $intIsSingle;
		if(isset($intIsSingle)){
			echo "a";
			if($intIsSingle==1){
				$strNumber .= $strNumber."-1-1-1-1-1";
			}
		}
		//echo $strNumber;
		$arrNumber = explode("-",$strNumber);
		
		/*Test if numeric value*/
		$tnum = 0;
		foreach($arrNumber as $key=>$val){
			if($val==""){
				$val="00";
			} else {
				if($val[0]=="0"){
					$val = substr( $val, 1 );
				} 
			}
			if (!preg_match('/^[0-9]+$/', $val)) {
				$tnum++;
			}			
		}
		
		/*Auto correct if one digit*/
		$com=0;
		foreach($arrNumber as $key => $val){
			if($val!=""){
				if(strlen($val)<=1){
					$arrNumber[$key] = "0".$val;
				}
				$com++;
			}	
		}	
		
		/*Test if Complete six digit*/
		if($com>=6){		
			/*Set array variable*/
			$data = array('intLottoType'=>$intLottoType,
							'a'=>$arrNumber[0],
							'b'=>$arrNumber[1],
							'c'=>$arrNumber[2],
							'd'=>$arrNumber[3],
							'e'=>$arrNumber[4],
							'f'=>$arrNumber[5],
							);
							
			/*Set total number to 0*/
			$totalNum[0] = 0;
			$totalNum[1] = 0;
			$totalNum[2] = 0;
			$totalNum[3] = 0;
			$totalNum[4] = 0;
			$totalNum[5] = 0;	

			/*Set probability to 0*/
			$probability[0] = 0;
			$probability[1] = 0;
			$probability[2] = 0;
			$probability[3] = 0;
			$probability[4] = 0;
			$probability[5] = 0;	

			/*winner count*/
			$w = 0;
			
			/*Logic type*/
			switch($strType){
				case "r6":
						/*Call model and get result*/
						
						/*Where intLottoType = '$intLottoType'*/
						$data2 = array('intLottoType'=>$intLottoType);
						$result[0] = $this->result_class->read(2,$data2);
						$result[1] = $this->result_class->read(1, $data);

						/*Results area*/
						$totalCount = 0;
						$totalFound = 0;
						
						if($result[0]>0){
							$totalCount = count($result[0]);
						}
						
						if($result[1]>0){
							$totalFound = count($result[1]);
						}
						
						if($result[1]!=0){
				
							/*Has data area*/
							foreach($result[1] as $key=>$val){
								$pos = false;
								$c = 0;
								
								$pos = strpos($val["strCombinations"], $arrNumber[0]);
								if ($pos !== false) {
									$totalNum[0]++;
									$c++;
								}
								$pos = strpos($val["strCombinations"], $arrNumber[1]);
								if ($pos !== false) {
									$totalNum[1]++;
									$c++;
								}	
								$pos = strpos($val["strCombinations"], $arrNumber[2]);
								if ($pos !== false) {
									$totalNum[2]++;
									$c++;
								}
								$pos = strpos($val["strCombinations"], $arrNumber[3]);
								if ($pos !== false) {
									$totalNum[3]++;
									$c++;
								}	
								$pos = strpos($val["strCombinations"], $arrNumber[4]);
								if ($pos !== false) {
									$totalNum[4]++;
									$c++;
								}	
								$pos = strpos($val["strCombinations"], $arrNumber[5]);
								if ($pos !== false) {
									$totalNum[5]++;
									$c++;
								}	
								if($c>=6){
									$w++;
								}				
								
							}
							
							/*Set data array*/
							$res["status"] = 0;
							$res["msg"] = "Success.";
							$res["winner"] = $w;
							$res["found"] = $totalFound;
							$res["result"][0] = array(
											"number"=>$arrNumber[0],
											"probability"=>(($totalNum[0]/$totalCount)*100)
										);
							$res["result"][1] = array(
											"number"=>$arrNumber[1],
											"probability"=>(($totalNum[1]/$totalCount)*100)
										);
							$res["result"][2] = array(
											"number"=>$arrNumber[2],
											"probability"=>(($totalNum[2]/$totalCount)*100)
										);
							$res["result"][3] = array(
											"number"=>$arrNumber[3],
											"probability"=>(($totalNum[3]/$totalCount)*100)
										);
							$res["result"][4] = array(
											"number"=>$arrNumber[4],
											"probability"=>(($totalNum[4]/$totalCount)*100)
										);
							$res["result"][5] = array(
											"number"=>$arrNumber[5],
											"probability"=>(($totalNum[5]/$totalCount)*100)
										);
						} else {
							
							/*No data area*/
							$res["status"] = -1;
							$this->error_handler("No game found.", $output);
						}
				break;
				case "c6":
					$data2 = array('intLottoType'=>$intLottoType);
					$result[0] = $this->result_class->read(2,$data2);
					
					$data = array(
									'intLottoType'=>$intLottoType,
									'strCombinations'=>$arrNumber[0].'-'.$arrNumber[1].'-'.$arrNumber[2].'-'.$arrNumber[3].'-'.$arrNumber[4].'-'.$arrNumber[5]
								);
					$result[1] = $this->result_class->read(2,$data);

					$totalCount = 0;
					$totalFound = 0;
					
					if($result[0]>0){
						$totalCount = count($result[0]);
					}
					
					if($result[1]>0){
						$totalFound = count($result[1]);
					}
						
					$res["status"] = 0;
					$res["msg"] = "Success.";
					$res["total_draw"] = $totalCount;
					$res["found"] = $totalFound;
					
				break;
				default:
					/*No logic area*/
					$res["status"] = -1;
					$this->error_handler("No logic found.", $output);
				break;
			}			
		} else {
			$res["status"] = -1;
			$this->error_handler("Incomplete number.", $output);	
		}
		
		/*Result of numeric value*/
		if($tnum>=1){
			if($com>=6){
				$res["status"] = -1;
				$this->error_handler("Error number.", $output);			
			}
		}
		
		if($res["status"]>=0){
			/*Set data sent*/
			$this->output($res , $output);
		}
	}
	
	/*Error function*/
	private function error_handler($msg=null, $output=null){
		$res["status"] = -1;
		$res["msg"] = $msg;
		if($msg==""){
			$res["msg"] = "Error.";
		}
		$this->output($res , $output);
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>