<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Game_type_class extends CI_Model {
	/*crud*/
	public function create($func = null, $data = null){
		switch($func){
			case 0:
				return 0;
			break;
			case 1:
				return 0;			
			break;
			default:
				return 0;
			break;
		}
	}	
	public function read($func = null, $data = null){
		switch($func){
			case 0:
				$this->db->order_by("intOrder","asc");
				$query = $this->db->get('game_type_tbl');
				if ($query->num_rows() > 0) {
						$result = $query->result_array();
						return $result;
				} else {
						return 0;
				}				
			break;
			case 1:
				return 0;				
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