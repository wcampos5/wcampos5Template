<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema {
	
	protected $CI;
	public $theme = array();	//Carrega titulo, conteudo, modulos, etc...

	//*** Contrutor ***
	public function __construct(){
	
			$this->CI =& get_instance();
			$this->CI->load->helper('funcoes');
		
	} //End of Contruct
	
	
	
	
} 

/*   End of file sistema.php  */
/*   Location: ./application/libraries/sistema.php  */