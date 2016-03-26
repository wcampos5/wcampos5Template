<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_model extends CI_Model {

	/*---------------------------------------------------------------------------
	 *										Construtor
	 ---------------------------------------------------------------------------*/
	 
	public function __construct(){
	
		parent::__construct();
		
	} //End of Contruct
	
	/*---------------------------------------------------------------------------
	 *										Functions
	 ---------------------------------------------------------------------------*/
	
	public function doInsert($data=NULL, $redir=FALSE) {
		if ($data != NULL) {
			$this->db->insert('audit', $data);
						
			if ($redir){
				//Atualiza a pagina corrente
				redirect(current_url());
			}
			
		} // ./End of has $data
	
	}  /* End of function doUpdate() */
	
	
	public function getByUserId($id=NULL) {
		if ($id != NULL){
			/* Defini a clausila where */
			$this->db->where('userId', $id);
			$this->db->limit(1);
				
			return $this->db->get('audit');
				
	
		} else {
			return FALSE;
		}
	}  /* End of getByUserId() */
	
	
	
	
	/**
	 * Function getAll()
	 *
	 * Retorna todos os dados da tabela users
	 * 
	 */
	public function getAll($limit=NULL) {
		if ($limit > 0) {
			$this->db->limit($limit);
			return $this->db->get('audit');
		} // ./End of $limit > 0
		
	}  /* End of function_getAll() */
	
} 

/*   End of file audit_model.php  */
/*   Location: ./application/models/audit_model.php  */