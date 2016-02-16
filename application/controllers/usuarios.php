<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		//Carrega todos os recursos necessários ao Painel (titulo padrão, view padrão, rodapé, libraries e helpers(incluindo Sistema))
		initPanel(); 
		
	} //End of Contruct
	
	
	//*** FUNCTIONS ***
	
	function index() {
		$this->load->view('TBD');
	
	} /* End of TBD */
	
	
	public function login() {
		
		setTheme('titulo', 'Login');
		setTheme('conteudo', loadModule('usuarios_view', 'login'));
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	}  /* End of login */
		
	
} //End of Controller Usuarios

/*   End of file usuarios.php  */
/*   Location: ./application/controllers/usuarios.php  */