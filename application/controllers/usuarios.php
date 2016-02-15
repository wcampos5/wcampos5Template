<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		$this->load->library('sistema');
		
	} //End of Contruct
	
	
	//*** FUNCTIONS ***
	
	function index() {
		$this->load->view('TBD');
	
	} /* End of TBD */
	
	
	public function login() {
		//Carrega o módulo usuários e mostrar a tela de login
		$this->load->view('painel_view');
	}  /* End of login */
		
	
} 

/*   End of file usuarios.php  */
/*   Location: ./application/controllers/usuarios.php  */