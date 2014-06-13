<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Six_digit_zero_nine_class extends CI_Model {
	/*crud*/
	public function create(){
		
	}	
	public function read($func = null, $data = null){
		switch($func){
			case 0:
				/*Select * */
				$query = $this->db->get('six_digit_zero_nine_tbl');
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						return $result;
				} else {
						return 0;
				}				
			break;
			case 1:
				/*Select * From table Where */
				$this->db->where($data);
				$query = $this->db->get('six_digit_zero_nine_tbl');
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						return $result;
				} else {
						return 0;
				}	
			break;
			case 2:
				/*Select * */
				$this->db->where($data);
				$query = $this->db->get('six_digit_zero_nine_tbl')->result_array();
				$query = current($query);
				
				if(trim($query['intID'])!="") {
						return $query;
				} else {
						return 0;
				}				
			break;			
			default:
				return 0;
			break;
		}	
	}	
	public function update($where = null, $set = null){

			$this->db->where($where);
			$this->db->update('six_digit_zero_nine_tbl', $set);

			if($this->db->_error_number()==0){
				$message['fail'] = 0;
				$message['class'] = "success";
				$message['message'] = "Updated";
			}else{
				$message['fail'] = 1;
				$message['class'] = "error";
				$message['message'] = $message['message'].$this->db->_error_message();;
			}
			return $message;
	}		
	public function delete(){
	
	}		
}

?>