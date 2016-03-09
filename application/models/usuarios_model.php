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
	
	public function doInsert($data=NULL, $redir=TRUE) {
		if ($data != NULL) {
			$this->db->insert('users', $data);
			
			//Verifica se realmente incluiu
			if ($this->db->affected_rows() > 0){
				//Envia mensagem de sucesso
				setMessage('msgOK', 'Cadastro efetuado com sucesso!!!', 'success');
			//Caso não $this->db->affected_rows() > 0
			} else {
				//Envia mensagem de erro
				setMessage('msgError', 'Cadastro naõ efetuado!!!', 'error');
			} // ./End of $this->db->affected_rows() > 0
			
			
			if ($redir){
				//Atualiza a pagina corrente
				redirect(current_url());
			}
			
		} // ./End of has $data
	
	}  /* End of function doUpdate() */
	
	public function doUpdate($data=NULL, $condition=NULL, $redir=TRUE) {
		if ($data != NULL && is_array($condition)) {
			//Atualiza a tabela usuarios no BD
			$this->db->update('users', $data, $condition);
			
			//Verifica se atualizou registro
			if ($this->db->afected_rows() > 0){
				setMessage('msgOK', 'Atualização efetuada com sucesso', 'success');
			//Caso não $this->db->afected_rows() > 0
			} else {
				setMessage('msgError', 'Erro ao tentar atualizar o registro', 'error');
			} // ./End of $this->db->afected_rows() > 0
			//Seta a msg de sucesso
			setMessage('msgOK', 'Atualização efetuada com sucesso' . var_dump($data), 'success');
			if ($redir){
				//Atualiza a pagina corrente
				redirect(current_url());
			}
		}
		
	}  /* End of function doUpdate() */
	
	
	public function doDelete($condition=NULL, $redir=TRUE) {
		if ($condition != NULL && is_array($condition)) {
			//Executa a deleção
			$this->db->delete('users', $condition);
			
			//Verifica se realmente excluiu
			if ($this->db->affected_rows() > 0){
				setMessage('msgOK', "Registro excluido com sucesso!!!", 'success');
			//Caso $this->db->affected_rows() <> 1
			} else {
				setMessage('msgError', "Registro não pode ser excluido!!!", 'error');
			} // ./End of $this->db->affected_rows() == 1
			
			
			if ($redir) {
				redirect(current_url());
			} // ./End of redir=TRUE
			
		} // ./End of condition exists and is an array
	}  /* End of function doDelete() */
	
	
	
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
	
	
	
	public function getByUserId($id=NULL) {
		if ($id != NULL){
			/* Defini a clausila where */
			$this->db->where('userId', $id);
			$this->db->limit(1);
				
			return $this->db->get('users');
				
	
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
	public function getAll() {
		return $this->db->get('users');
	}  /* End of function_getAll() */
	
} 

/*   End of file usuarios_model.php  */
/*   Location: ./application/path/usuarios_model.php  */