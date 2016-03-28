<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AteliePapelPicado extends CI_Controller {

	//*** Contrutor ***
	public function __construct(){
	
		parent::__construct();
		$this->load->library('Sistema');
		initPanel();
		
	} //End of Contruct
	
	//*** FUNCTIONS ***
	
	public function index() {
		//Chama a função que carregara a view
		
	}  /* End of index */
	
	
} 

/*   End of file ateliepapelpicado.php  */
/*   Location: ./application/controllers/AteliePapelPicado.php  */