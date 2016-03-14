<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		$this->load->library('Sistema');
		initPanel();
		
	} //End of Contruct
	
	//*** FUNCTIONS ***
	
	public function index() {
		//Chama a função inicio que carregara a view usuarios
		$this->inicio();
	}  /* End of index */
	
	public function inicio() {
		
		if (isLogged()){
			//Defini os dados para serem exibidos em painel_view
			setTheme('titulo', 'Inicio');
			setTheme('conteudo', '<div class="col-sm-12 col-md-12 col-lg-12"><p>Escolha um menu para iniciar</p></div>');
			
			//Carrega o tema
			loadTemplate();
			
		} else {
			//Informa o motivo do redirecionamento
			setMessage('loginNotOK', 'Acesso RESTRITO, favor efetuar o login', 'error');
			redirect('usuarios/login');
		}
		
	}  /* End of inicio */
	
} 

/*   End of file painel.php  */
/*   Location: ./application/controllers/painel.php  */