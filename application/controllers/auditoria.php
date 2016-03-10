<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auditoria extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		
		//Carrega todos os recursos necessários ao Painel (titulo padrão, view padrão, rodapé, libraries e helpers(incluindo Sistema))
		initPanel(); 
		
		//Verifica se esta logado
		isLogged();
		
		isAdmin(TRUE);
		
		//Carrega o Model Auditoria
		$this->load->model('audit_model', 'audit');
		
	} //End of Contruct
	
	
	//*** FUNCTIONS ***
	
	function index() {
		$this->gerenciar();
	
	} /* End of TBD */
	
	
	
	
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
		
		
		
		setTheme('titulo', 'Gerenciamento de auditoria'); //Define o titulo da página em usuarios_view()
		setTheme('conteudo', loadModule('auditoria_view', 'gerenciar')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
		
	}  /* End of function_gerenciar */
	
	
	
	
		
	
} //End of Controller Auditoria

/*   End of file auditoria.php  */
/*   Location: ./application/controllers/auditoria.php  */