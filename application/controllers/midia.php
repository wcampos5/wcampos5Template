<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Midia extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		
		//Carrega todos os recursos necessários ao Painel (titulo padrão, view padrão, rodapé, libraries e helpers(incluindo Sistema))
		initPanel(); 
		
		//Verifica se esta logado
		isLogged();
		
		isAdmin(TRUE);
		
		//Carrega o Model Auditoria
		$this->load->model('midia_model', 'midia');
		
	} //End of Contruct
	
	
	//*** FUNCTIONS ***
	
	function index() {
		$this->gerenciar();
	
	} /* End of TBD */
	
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function cadastrar()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Adiciona midias
	 *
	 */
	public function cadastrar() {
		
		//carrega a library html
		$this->load->helper('html');
		
		/* Valida os dados recebidos do formulario */
		$this->form_validation->set_rules('name', 'NOME', 'trim|required|ucfirst');
		$this->form_validation->set_rules('description', 'DESCRIÇÃO', 'trim');
		
		
		if ($this->form_validation->run() == TRUE) {
			
			//Primeiramente tenta fazer o upload do arquivo que veio do formulario
			$upload = $this->midia->doUpload('file'); //doUpload do model midia_model
			
			if (is_array($upload) && $upload['file_name'] != ''){ //upload com sucesso
				//Pega os dados vindos do formulario
				$data = elements(array('name', 'description'), $this->input->post());
				//Le a informação recebida da library do_upload acionada no model midia_model doUpload
				$data['file'] = $upload['file_name'];
				
				//Insere no banco de dados
				$this->midia->doInsert($data);
				
			//Caso o upload não tenha ocorrido com sucesso
			} else {
				setMessage('msgError', $upload, 'error');
				redirect(current_url());
			} // ./End of condition
			
			
			
			
				
			
		}
	
		setTheme('titulo', 'Carregamento de imagens'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('midia_view', 'cadastrar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	
	}  /* End of function cadastrar() */
	
	
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function gerenciar()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Listagem de usuarios usando JQuery Data Tables
	 *
	 */
	public function gerenciar() {
		
		$this->load->helper('html');
		
		//Carrega o data-table.js e o tabel.js
		setTheme('jsInclude', loadJS('table.js', 'assets/js', FALSE),FALSE);
		
		
		
		setTheme('titulo', 'Gerenciamento de midias'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('midia_view', 'gerenciar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
		
	}  /* End of function_gerenciar */
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function editar()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Permite a edição de midias
	 *
	 */
	public function editar() {
	
		/* Valida os dados recebidos do formulario */
		$this->form_validation->set_rules('name', 'NOME', 'trim|required|ucfirst');
		$this->form_validation->set_rules('description', 'DESCRIÇÃO', 'trim');
	
		//Se passar pela validação
		if ($this->form_validation->run() == TRUE) {
			//Pega os dados vindos do formulario
				$data = elements(array('name', 'description'), $this->input->post());
					
			//Altera a senha no BD
			$this->midia->doUpdate($data, array('midiaId'=>$this->input->post('midiaId')), TRUE);
		}
	
	
		setTheme('titulo', 'Editar Midia'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('midia_view', 'editar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	
	}  /* End of function editar */
	
	
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function excluir()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Permite a exclusão de um usuario
	 *
	 */
	public function excluir() {
	
		//Verifica se esta logado
		isLogged();
	
		//Verifica se é administrador
		if (isAdmin(TRUE)){
	
			//Recebe o userId no 3o segmento da URI
			$midiaId = $this->uri->segment(3);
	
			//Caso o 3o segmento exista
			if ($midiaId != NULL){
	
				//Retorna a linha correspondente do banco de dados
				$query = $this->midia->getById($midiaId);
	
				//Se retornar uma linha
				if ($query->num_rows() == 1){
	
					$query = $query->row();
						
					//Remove o arquivo da pasta uploads
					//TODO: Ativar		unlink('uploads/' . $query->file);
						
					//Deleta todos os thumbnails criados
					$thumbs = glob('./uploads/thumbs/*_' . $query->file);
						
					foreach ($thumbs as $item) {
						unlink($item);
					}
	
					$this->midia->doDelete(array('midiaId'=>$midiaId), FALSE);
	
					//Caso não $query->num_rows() <> 1
				} else {
					setMessage('msgError', 'Midia Inexistente', 'error');
				} // ./End of $query->num_rows() == 1
	
				//Caso $userIdSegment == NULL
			} else {
				setMessage('msgError', 'Selecione uma mídia para deletar', 'error');
					
			} // ./End of $userIdSegment != NULL
	
			redirect('midia/gerenciar');
	
		} else {
			redirect('midia/gerenciar');
		}// ./End of isAdmin(TRUE)
	
	}  /* End of function excluir() */
	
	
	
	
}/*   End of file midia.php  */
/*   Location: ./application/controllers/midia.php  */