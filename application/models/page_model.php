<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {

	/*---------------------------------------------------------------------------
	 *										Functions
	 ---------------------------------------------------------------------------*/
	
	public function doInsert($data=NULL, $redir=TRUE) {
		if ($data != NULL) {
			$this->db->insert('pages', $data);
				
			//Verifica se realmente incluiu
			if ($this->db->affected_rows() > 0){
				audit('Inclusão de página', 'Nova página cadastrada');
				//Envia mensagem de sucesso
				setMessage('msgOK', 'Cadastro efetuado com sucesso!!!', 'success');
				//Caso não $this->db->affected_rows() > 0
			} else {
				//Envia mensagem de erro
				audit('Tentativa INCLUSÃO de PÁGINA', 'Tentativa de Inclusão de midia sem sucesso');
				setMessage('msgError', 'Cadastro  de página naõ efetuado!!!', 'error');
			} // ./End of $this->db->affected_rows() > 0
				
				
			if ($redir){
				//Atualiza a pagina corrente
				redirect(current_url());
			}
				
		} // ./End of has $data
	
	}  /* End of function doInsert() */
	
	
	
	
	public function doUpdate($data=NULL, $condition=NULL, $redir=TRUE) {
		if ($data != NULL && is_array($condition)) {
			//Atualiza a tabela usuarios no BD
			$this->db->update('pages', $data, $condition);
	
			//Verifica se atualizou registro
			if ($this->db->affected_rows() > 0){
				audit('Alteração Página no BD', 'Alteração efetuada com sucesso');
				setMessage('msgOK', 'Atualização efetuada com sucesso', 'success');
				//Caso não $this->db->afected_rows() > 0
			} else {
				audit('Alteração no BD', 'Alteração sem sucesso');
				setMessage('msgError', 'Erro ao tentar atualizar o registro', 'error');
			} // ./End of $this->db->afected_rows() > 0
	
			audit('Alteração no BD', 'Alteração sem sucesso');
			//Seta a msg de sucesso
			setMessage('msgOK', 'Atualização efetuada com sucesso', 'success');
			if ($redir){
				//Atualiza a pagina corrente
				redirect(current_url());
			}
		}
	
	}  /* End of function doUpdate() */
	
	
	
	public function doDelete($condition=NULL, $redir=TRUE) {
		if ($condition != NULL && is_array($condition)) {
			//Executa a deleção
			$this->db->delete('pages', $condition);
	
			//Verifica se realmente excluiu
			if ($this->db->affected_rows() > 0){
				audit('DELEÇÃO de pagina no BD', 'DELEÇÃO de página ' . $condition['pageId'] . ' efetuada com sucesso');
				setMessage('msgOK', "Página excluida com sucesso!!!", 'success');
				//Caso $this->db->affected_rows() <> 1
			} else {
				audit('TENTATIVA DELEÇAO  de PÁGINA BD', 'DELEÇÃO de PÁGINA ' . $condition['pageId'] . ' não efetuada com sucesso');
				setMessage('msgError', "Página não pode ser excluida!!!", 'error');
			} // ./End of $this->db->affected_rows() == 1
	
	
			if ($redir) {
				redirect(current_url());
			} // ./End of redir=TRUE
	
		} // ./End of condition exists and is an array
	}  /* End of function doDelete() */
	
	
	
	
	
	
	public function doUpload($field) {
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpeg|png';
		
		//Carrega a library que carrega arquivos e inclui a configuração
		$this->load->library('upload', $config);
		
		//Usa a library do CI para efetuar o carregamento
		//Verifica se o carregamento ocorreu com sucesso
		if ($this->upload->do_upload($field)){
			
			return $this->upload->data();
			
		//Caso não $this->upload
		} else {
			return $this->upload->display_errors();
		} // ./End of $this->upload
		
		
	}  /* End of function doUpload*/
	
	
	public function getById($id=NULL) {
		if ($id != NULL){
			/* Defini a clausila where */
			$this->db->where('pageId', $id);
			$this->db->limit(1);
	
			return $this->db->get('pages');
	
	
		} else {
			return FALSE;
		}
	}  /* End of getById() */
	
	
	/**
	 * Function getAll()
	 *
	 * Retorna todos os dados da tabela midia
	 *
	 */
	public function getAll() {
		return $this->db->get('pages');
	}  /* End of function_getAll() */
	
	
} 

/*   End of file midia_model.php  */
/*   Location: ./application/path/midia_model.php  */