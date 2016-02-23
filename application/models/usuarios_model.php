<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	/*---------------------------------------------------------------------------
	 *										Construtor
	 ---------------------------------------------------------------------------*/
	 
	public function __construct(){
	
		parent::__construct();
		
	} //End of Contruct
	
	/*---------------------------------------------------------------------------
	 *										Functions
	 ---------------------------------------------------------------------------*/
	
	public function doUpdate($data=NULL, $condition=NULL, $redir=TRUE) {
		if ($data != NULL && is_array($condition)) {
			//Atualiza a tabela usuarios no BD
			$this->db->update('users', $data, $condition);
			//Seta a msg de sucesso
			setMessage('msgOK', 'Atualização efetuada com sucesso', 'success');
			if ($redir){
				//Atualiza a pagina corrente
				redirect(current_url());
			}
		}
		
	}  /* End of function doUpdate() */
	
	/**
	 * Function doLogin()
	 * 
	 * Verifica se o usário esta logado.
	 * Recebe o usuario e a senha, caso existam e sejam compativeis retorna TRUE para quem chamou
	 * 
	 * @param string $email
	 * @param string $password
	 * @return boolean
	 */
	public function doLogin($email=NULL, $password=NULL) {
		
		if ($email && $password){
			/* Defini a clausula where*/
			$this->db->where('email', $email);
			$this->db->where('password', $password);
			$this->db->where('active', 1);
			
			$query = $this->db->get('users');
			
			if ($query->num_rows() == 1) {
				return TRUE;
			} else {
				return FALSE;
			}
				
		//Caso não receba usuario ou senha
		} else {
			return FALSE;
		}
		
	} // ./doLogin()
	
	
	
	public function getByEmail($email=NULL) {
		if ($email != NULL){
			/* Defini a clausila where */
			$this->db->where('email', $email);
			$this->db->limit(1);
			
			return $this->db->get('users');
			
		
		} else {
			return FALSE;
		}
	}  /* End of getByEmail() */
	
} 

/*   End of file usuarios_model.php  */
/*   Location: ./application/path/usuarios_model.php  */