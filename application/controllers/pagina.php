<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pagina extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		
		//Carrega todos os recursos necessários ao Painel (titulo padrão, view padrão, rodapé, libraries e helpers(incluindo Sistema))
		initPanel(); 
		
		//Verifica se esta logado
		isLogged();
		
		isAdmin(TRUE);
		
		//Carrega o Model Auditoria
		$this->load->model('page_model', 'page');
		
	} //End of Contruct
	
	
	//*** FUNCTIONS ***
	
	function index() {
		$this->gerenciar();
	
	} /* End of index() */
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function cadastrar()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Adiciona midias
	 *
	 */
	public function cadastrar() {
		
	
		/* Valida os dados recebidos do formulario */
		$this->form_validation->set_rules('title', 'TÍTULO', 'trim|required|ucfirst');
		$this->form_validation->set_rules('slug', 'SLUG', 'trim');
		$this->form_validation->set_rules('content', 'CONTEÚDO', 'trim|required|htmlentities');
	
		if ($this->form_validation->run() == TRUE) {
				
				//Pega os dados vindos do formulario
				$data = elements(array('title', 'slug', 'content'), $this->input->post());
				//Verifica se recebeu um slug ou nao
				($data['slug'] != '') ? $data['slug'] = genSlug($data['slug'])  : $data['slug'] = genSlug($data['title']) ;
	
				//Insere no banco de dados
				$this->page->doInsert($data);
	
				//Caso o upload não tenha ocorrido com sucesso
				setMessage('msgError', $upload, 'error');
				redirect(current_url());
				
				
				
				
	
				
		}
		
		//Chama a função que inicializa o Tiny MCE
		initHtmlEditor();
		setTheme('titulo', 'Cadastrar nova página'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('page_view', 'cadastrar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
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
		
		//Inclui um arquivo CSS local
		setTheme('cssInclude', loadCSS(array('//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css'),'','All',TRUE), FALSE);
		
		//Inclui os arquivos JS
		//Inclui os JS remotos
		setTheme('jsInclude', loadJS(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
				'//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js'
		),'',TRUE), FALSE);
	
		//Carrega o data-table.js e o tabel.js
		setTheme('jsInclude', loadJS('table.js', 'assets/js', FALSE),FALSE);
	
	
	
		setTheme('titulo', 'Gerenciamento de páginas'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('page_view', 'gerenciar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	
	}  /* End of function_gerenciar */
	
	
	
	
} /*   End of file page.php  */
/*   Location: ./application/controllers/page.php  */