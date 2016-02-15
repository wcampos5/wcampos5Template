<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Carrega uma view do sistema devolvendo a tela solicitada
function load_module($viewModule=NULL, $screen=NULL, $directory='painel') {
	$CI =& get_instance();
	
	if ($viewModule != NULL) {
		return $CI->load->view("$directory/$viewModule", array('screen'=>$screen), TRUE); //TRUE retorna a tela em forma de variavel
	} else{
		return FALSE;
	}
	
	
	
}  /* End of load_module */







/*   End of file funcoes_helper.php  */
/*   Location: ./application/helpers/funcoes_helper.php  */