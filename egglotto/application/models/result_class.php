<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Result_class extends CI_Model {
	/*crud*/
	public function create($func = null, $data = null){
		switch($func){
			case 0:
				$value = array(
								'intLottoType' => $data['intLottoType'],
								'strLottoGame' => $data['0'],
								'strCombinations' => $data['1'],
								'dateDrawDate' => $data['2'],
								'dJackpot' => $data['3'],
								'intWinners' => $data['4']
				);
				
				$this->db->insert('result_tbl', $value);
			   
				
				if($this->db->_error_number()==0){
						$return['status'] = 0;
						$return['error_tbl'] = 0;
						$return['class'] = "success";
						$return['message'] = "Saved";
						$return['intID'] = $this->db->insert_id();
				}else{
						$return['status'] = 1;
						$return['error_tbl'] = 0;
						$return['class'] = "error";
						$return['message'] = $message['message'].$this->db->_error_message();
				}
				return $return;

			break;
			case 1:
				$value = array(
								'intLottoType' => $data['intLottoType'],
								'strLottoGame' => $data['0'],
								'strCombinations' => $data['1'],
								'dateDrawDate' => $data['2'],
								'dJackpot' => $data['3'],
								'intWinners' => $data['4']
				);
				
				$this->db->insert('error_result_tbl', $value);
			   
				
				if($this->db->_error_number()==0){
						$return['status'] = 0;
						$return['error_tbl'] = 1;
						$return['class'] = "success";
						$return['message'] = "Saved";
						$return['intID'] = $this->db->insert_id();
				}else{
						$return['status'] = 1;
						$return['error_tbl'] = 1;
						$return['class'] = "error";
						$return['message'] = $message['message'].$this->db->_error_message();
				}
				return $return;		
			break;
			default:
				return 0;
			break;
		}
	}	
	public function read($func = null, $data = null){
		switch($func){
			case 0:
			
				$query = $this->db->get('result_tbl');
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						return $result;
				} else {
						return 0;
				}				
			break;
			case 1:
			
				$sql = "SELECT * 
						FROM  `result_tbl` 
						WHERE intLottoType = '".$this->db->escape_str($data['intLottoType'])."' AND (LOCATE('".$this->db->escape_str($data['a'])."', `strCombinations`)
							OR LOCATE('".$this->db->escape_str($data['b'])."', `strCombinations`) 
							OR LOCATE('".$this->db->escape_str($data['c'])."', `strCombinations`) 
							OR LOCATE('".$this->db->escape_str($data['d'])."', `strCombinations`) 
							OR LOCATE('".$this->db->escape_str($data['e'])."', `strCombinations`) 
							OR LOCATE('".$this->db->escape_str($data['f'])."', `strCombinations`))";
				
				$query = $this->db->query($sql);		
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						return $result;
				} else {
						return 0;
				}				
			break;
			case 2:
			
				$this->db->where($data);
				$query = $this->db->get('result_tbl');
				
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						return $result;
				} else {
						return 0;
				}	
			break;
			case 3:
			
				$this->db->where($data);
				$query = $this->db->get('result_tbl')->result_array();
				$query = current($query);
				
				if(trim($query['intID'])!="") {
						return $query;
				} else {
						return 0;
				}	

			break;
			case 4:
				$sql = 'SELECT * 
						FROM  `result_tbl` 
						WHERE `intLottoType` = "'.$this->db->escape_str($data['intLottoType']).'" 
						AND `dateDrawDate` >=  "'.$this->db->escape_str($data['dateDrawDate_to']).'"
						AND `dateDrawDate` <=  "'.$this->db->escape_str($data['dateDrawDate_from']).'"';
				
				$query = $this->db->query($sql);	

				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						return $result;
				} else {
						return 0;
				}	
			break;
			case 5:
			
				$this->db->where($data);
				$query = $this->db->get('error_result_tbl');
				
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						return $result;
				} else {
						return 0;
				}	
			break;			
			default:
				return 0;
			break;
		}	
	}	
	public function update(){
	
	}		
	public function delete(){
	
	}		
}

?>