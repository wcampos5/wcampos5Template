<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Midia_model extends CI_Model {

	/*---------------------------------------------------------------------------
	 *										Functions
	 ---------------------------------------------------------------------------*/
	
	public function doInsert($data=NULL, $redir=TRUE) {
		if ($data != NULL) {
			$this->db->insert('midia', $data);
				
			//Verifica se realmente incluiu
			if ($this->db->affected_rows() > 0){
				audit('Inclusão de midia', 'Nova midia cadastrada');
				//Envia mensagem de sucesso
				setMessage('msgOK', 'Cadastro efetuado com sucesso!!!', 'success');
				//Caso não $this->db->affected_rows() > 0
			} else {
				//Envia mensagem de erro
				audit('Tentativa INCLUSÃO de MIDIA', 'Tentativa de Inclusão de midia sem sucesso');
				setMessage('msgError', 'Cadastro  de midia naõ efetuado!!!', 'error');
			} // ./End of $this->db->affected_rows() > 0
				
				
			if ($redir){
				//Atualiza a pagina corrente
				redirect(current_url());
			}
				
		} // ./End of has $data
	
	}  /* End of function doInsert() */
	
	
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
	
} 

/*   End of file midia_model.php  */
/*   Location: ./application/path/midia_model.php  */