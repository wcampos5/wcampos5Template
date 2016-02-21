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
		/* Valida os dados recebidos do formulario */
		$this->form_validation->set_rules('email', 'USUÁRIO', 'trim|required|min_length[4]|strtolower');
		$this->form_validation->set_rules('password', 'SENHA', 'trim|required|min_length[4]|strtolower');
		
		//Se passar pela validação
		if ($this->form_validation->run() == TRUE){
			//Recebe os dados do formulario nas variaveis:
			$email = $this->input->post('email', TRUE); //TRUE para XSS
			//Recebe e converte para MD5SUM
			$password = md5($this->input->post('password', TRUE));
			
			/*Chama a função doLogin do Model Usuarios passando usuario e senha
			 * caso o usuario exista e esteja ativo retorna TRUE
			 */
			if ($this->usuarios->doLogin($email, $password) == TRUE){
				echo 'login ok';
			} else {
				echo 'login falhou!!!';
			} // ./doLogin do Model Usuarios
			
		} // ./form_validation->run()
		
		/* Fim da validação do formulario */
		
		
		setTheme('titulo', 'Login'); //Define o titulo da página em painel_view()
		setTheme('conteudo', loadModule('usuarios_view', 'login')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	}  /* End of login */
		
	
} //End of Controller Usuarios

/*   End of file usuarios.php  */
/*   Location: ./application/controllers/usuarios.php  */