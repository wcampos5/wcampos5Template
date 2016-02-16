<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		$this->load->library('Sistema');
		
	} //End of Contruct
	
	//*** FUNCTIONS ***
	
	public function index() {
		//Chama a função inicio que carregara a view usuarios
		$this->inicio();
	}  /* End of index */
	
	public function inicio() {
		redirect('usuarios/login');
	}  /* End of inicio */
	
} 

/*   End of file painel.php  */
/*   Location: ./application/controllers/painel.php  */