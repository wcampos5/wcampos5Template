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
	
	/*---------------------------------------------------------------------------
	 *										Function Login()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Recebe e valida os dados recebidos do formulário
	 * - Chama o Model doLogin para verificar se usuario e senha coincide
	 *  - Configura a sessão do usuário
	 * 
	 */
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
			 * caso o usuario exista, senha seja correta e ele esteja ativo retorna TRUE
			 */
			
			//Login OK
			if ($this->usuarios->doLogin($email, $password) == TRUE){
				
				//Extrai o os dados do usuario do BD e alimenta a sessão
				$query = $this->usuarios->getByEmail($email)->row();	//Recebe os dados do usuario especifico
				
				//Array Dados com as variaveis de sessão
				$data = array(
						'userId' => $query->userId,
						'email'	=> $query->email,
						'name' => $query->name,
						'userAdm' => $query->adm,
						'logged' => TRUE
						
				);
				
				$this->session->set_userdata($data);
				
				redirect('painel');
				
			//Login NOT OK
			} else {
				
				$query = $this->usuarios->getByEmail($email)->row();
				
				if (empty($query)){
					setMessage('loginNotOK', 'Desculpe usuário e(ou) senha inválido(a). Tente novamente!'); //Usuario não existe
				} elseif ($query->password != $password) {
					setMessage('loginNotOK', 'Desculpe usuário e(ou) senha inválido(a). Tente novamente!'); //Senha invádlida
				} elseif ($query->active == 0) {
					setMessage('loginNotOK', 'Desculpe este usuario esta temporariamente inativo, contate o administrador.'); //Usuario inativo
				} else {
					setMessage('loginNotOK', 'Infelizmente ocorreu um erro desconhecido, contate o administrador!'); //Outros erros
				}
				
				redirect('usuarios/login');
			} // ./doLogin do Model Usuarios
			
		} // ./form_validation->run()
		
		/* Fim da validação do formulario */
		
		
		setTheme('titulo', 'Login'); //Define o titulo da página em painel_view()
		setTheme('conteudo', loadModule('usuarios_view', 'login')); //Passa o conteudo da view usuarios_view->login via parse na tag conteudo no painel_view
		//Carrega o módulo usuários e mostrar a tela de login
		loadTemplate();
	}  /* End of function login() */
	
	
	
	/*---------------------------------------------------------------------------
	 *									Function logoff()
	 ---------------------------------------------------------------------------*/
	/*
	 * - Limpa as variaveis de sistema
	 * - Destroi a sessão
	 *
	 */
	public function logoff() {
		//Defini o array dos dados que faram parte do unset
		$cleanSession = array('userId', 'email','name', 'userAdm', 'logged');
		$this->session->unset_userdata($cleanSession);
		
		//Seta a mensagem
		setMessage('logoffOK', 'Usuário desconectado com sucesso!', 'success');
		redirect('usuarios/login');
		
		$this->session->sess_destroy();
		
	}  /* End of function logoff() */
	
	
	
		
	
} //End of Controller Usuarios

/*   End of file usuarios.php  */
/*   Location: ./application/controllers/usuarios.php  */