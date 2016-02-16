<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Carrega uma view do Sistema devolvendo a tela solicitada
function loadModule($viewModule=NULL, $screen=NULL, $directory='painel') {
	$CI =& get_instance();
	
	if ($viewModule != NULL) {
		return $CI->load->view("$directory/$viewModule", array('screen'=>$screen), TRUE); //TRUE retorna a tela em forma de variavel
	} else{
		return FALSE;
	}	
	
}  /* End of loadModule */


/**	
 * Seta os valores do array Theme
 * @param string $property
 * @param string $value
 * @param string $replace
 */
function setTheme($property, $value, $replace=TRUE) {
	
	$CI =& get_instance();
	$CI->load->library('Sistema');
	
	//Caso seja para substituir propriedade e o valor
	if ($replace){
		$CI->Sistema->theme[$property] = $value;
	//Caso NÃO seja para substituir e sim agregar propriedade e o valor
	} else {
		//Caso NÃO esteja setada a propriedade, configura como vazia inicialmente
		if (!isset($CI->Sistema->theme[$property])) {
			$CI->Sistema->theme[$property] = '';
			//Concatena o valor
			$CI->Sistema->theme[$property] .= $value;
		} else {
			//Concatena o valor
			$CI->Sistema->theme[$property] .= $value;
		}
	}
	
}  /* End of setTheme */



function getTheme() {
	
	$CI =& get_instance();
	$CI->load->library('Sistema');
	
	return $CI->Sistema->theme;

}  /* End of getTheme */

/**
 * Carrega os recursos necessários ao Painel Administrativo
 */
function initPanel() {
	
	$CI =& get_instance();
	$CI->load->library(array('Sistema', 'session', 'form_validation'));
	$CI->load->helper(array('form', 'url', 'array', 'text'));
	
	//Carregamento dos Model
	
	//Configuração de propriedades padrão do Painel de Gerenciamento
	setTheme('defaultTitle', 'Painel Administrativo');
	setTheme('footer', '<p>XXX &copy; 2016 | Todos os direitos reservados.</p>');
	//Definição da view principal do Painel Administrativo
	setTheme('template', 'painel_view');
	
}  /* End of initiPanel() */



/*
 * Carrega um Template passado o array $theme como paramentro.
 * 
 * Carrega o template $theme definido na classe Sistema
 */

function loadTemplate() {
	
	$CI =& get_instance();
	$CI->load->library('Sistema');
	//Passa os argumentos da função
	$CI->parser->parse($CI->Sistema->theme['template'], getTheme()); //array template é a propriedade definida na funcao initPanel->setTheme

	
}  /* End of loadTemplate */





/*   End of file funcoes_helper.php  */
/*   Location: ./application/helpers/funcoes_helper.php  */