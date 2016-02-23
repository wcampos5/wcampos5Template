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
	
	
	
	public function sendEmail($to, $subject, $message, $format='html') {
		$this->CI->load->library('email');
		
		$config['mailtype'] = $format;
		
		$this->CI->email->initialize($config);
		
		$this->CI->email->from('adm@site.com', 'Administração do Site');
		$this->CI->email->to($to);
		$this->CI->email->subject($subject);
		$this->CI->email->message($message);
		
		//Verifica se foi enviado com sucesso
		if ($this->CI->email->send()){
			return TRUE;
		} else {
			return $this->CI->email->print_debugger();
		}
		
	}  /* End of End of sendEmail() */
	
	
	
	
} 

/*   End of file sistema.php  */
/*   Location: ./application/libraries/sistema.php  */