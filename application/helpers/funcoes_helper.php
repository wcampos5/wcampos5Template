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
	$CI->load->model('usuarios_model', 'usuarios');
	
	//Configuração de propriedades padrão do Painel de Gerenciamento
	//Inclui um arquivo CSS local
	setTheme('cssInclude', loadCSS(array('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
	'//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css'),'','All',TRUE), FALSE);
	setTheme('cssInclude', loadCSS('app.css','assets/css','All',FALSE),FALSE);
	
	//Inclui os arquivos JS
	/* setTheme('jsInclude', loadJS(array('jquery.min', FALSE)), FALSE); //Exemplo local */
	//Inclui os JS remotos
	setTheme('jsInclude', loadJS(array('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',
			'//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js',
			'//cdn.tinymce.com/4/tinymce.min.js'
	),'',TRUE), FALSE);
	
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


/**
 *
 * Carrega os arquivos CSS locais e remotos
 * 
 * @param string $cssFile
 * @param string $folder
 * @param string $media
 */
function loadCSS($cssFile=NULL, $folder='assets/css', $media='All', $remote=FALSE) {
	
	if ($cssFile != NULL) {
		//Carrega a instancia do CI
		$CI =& get_instance();
		$CI->load->helper('url'); //Carrega a library url
		$strRetorno = ''; //Inicializa a variavel strRetorno como vazia
		
		//Caso receba mais de um css
		if (is_array($cssFile)){
			//Para cada item do array
			foreach ($cssFile as $cssItem) {
				//Verificar se remoto é verdadeiro
				if ($remote){
					$strRetorno .= '<link rel="stylesheet" type="text/css" href="' . "$cssItem" . '" media="' . $media . '" />';
				} else {
					$strRetorno .= '<link rel="stylesheet" type="text/css" href="' . base_url("$folder/$cssItem") . '" media="' . $media . '" />';
				}
			}
		//Se $cssFile não for um array
		} else {
			if ($remote){
				
				$strRetorno = '<link rel="stylesheet" type="text/css" href="' . "$cssFile" . '" media="' . $media . '" />';
				
			}else{
				
				
				$strRetorno = '<link rel="stylesheet" type="text/css" href="' . base_url("$folder/$cssFile") . '" media="' . $media . '" />';
			}
			
		} // ./else is_array($cssFile)
		
	} //. $cssFile not NULL
	
	return $strRetorno;
	
}  /* End of loadCSS() */

/**
 * Carrega os arquivos JS locais e remotos
 * 
 * @param string $File
 * @param string $folder
 * @param boolean $remote
 * @return string
 */
 

function loadJS($File=NULL, $folder='assets/js', $remote=FALSE) {
	if ($File != NULL) {
		//Carrega a instancia do CI
		$CI =& get_instance();
		$CI->load->helper('url'); //Carrega a library url
		$strRetorno = ''; //Inicializa a variavel strRetorno como vazia
		
		if (is_array($File)){
			
			foreach ($File as $jsItem) {
				//Verifica se remoto é verdadeiro
				if ($remote){
					$strRetorno .= '<script type="text/javascript" src="' . $jsItem .'"></script>';
				}else{
					$strRetorno .= '<script type="text/javascript" src="' . base_url("$folder/$jsItem") . '"></script>';
				}
			}
		//Se não for um array
		} else {
			//Verifica se remoto é verdadeiro
			if ($remote) {
				$strRetorno .= '<script type="text/javascript" src="' . "$File" .'"></script>';
			}else{
				$strRetorno .= '<script type="text/javascript" src="' . base_url("$folder/$File") . '"></script>';
			}
		}
		
		}
	
	return $strRetorno;
}  /* End of loadJS() */


/*
 * Mostra erros de validação em formulários
 */
function showFormErrors() {
	
	if (validation_errors()) {
		echo '<div class="alert alert-danger">' . validation_errors('<p>','</p>') . '</div>';
	}
	
}  /* End of showFormErros */



function isLogged($redir=TRUE) {
	//Carrega a instancia do CI
	$CI =& get_instance();
	$CI->load->library('session'); //Carrega a library session;
	
	//Lê a variavel de sessão looged
	$userStatus = $CI->session->userdata('logged');
	
	if (!isset($userStatus) || $userStatus != TRUE){
		//Defini o looged como falso
		$_SESSION['logged'] = FALSE;
		
		if ($redir) {
			//Informa o motivo do redirecionamento
			setMessage('loginNotOK', 'Acesso RESTRITO, favor efetuar o login', 'error');
			redirect('usuarios/login');
		} else {
			return FALSE;
		}
	} else {
		return TRUE;
	}
	
}  /* End of isLogged */

function isAdmin($sendMessage=FALSE) {
	//Carrega a instancia do CI
	$CI =& get_instance();
	
	//recebe o usuario da sessão
	$userAdmin = $CI->session->userdata('userAdm');
	
	//Verifica se o usuario não esta instanciado ou não é administrador
	if (!isset($userAdmin) || $userAdmin != TRUE){
		//Verifica se é para retornar mensagem
		if ($sendMessage) {
			setMessage('msgError', 'Operação não permitida para este usuário', 'error');
			return FALSE;
		}
	
	} else {
		
		return TRUE;
	
	}
}  /* End of function isAdmin */


/*
 * Defini uma mensagem de erro para a proxima requição
 */
function setMessage($msgId='errorMessage', $message=NULL, $msgType='error' ) {
	//Carrega a instancia do CI
	$CI =& get_instance();
	$CI->load->library('session'); //Carrega a library session;
	
	switch ($msgType) {
		case 'error':
			$CI->session->set_flashdata($msgId, '<div class="alert alert-danger"><p>' . $message . '</p></div>');
		break;
		
		case 'success':
			$CI->session->set_flashdata($msgId, '<div class="alert alert-success"><p>' . $message . '</p></div>');;
			break;
		
		default:
			$CI->session->set_flashdata($msgId, '<div class="alert alert-danger"><p>' . $message . '</p></div>');
		break;
	};
}  /* End of function_container */


/*
 * Retorna uma mensagem de caso esteja setada e exibe na tela atual
 */
function getMessage($msgId, $print=TRUE) {
	//Carrega a instancia do CI
	$CI =& get_instance();
	$CI->load->library('session'); //Carrega a library session;
	
	//Verifica se a variavel esta setada
	if ($CI->session->flashdata($msgId)){
		//Verifica se é para imprimir a variavel ou retorna-la apenas
		if ($print){
			echo $CI->session->flashdata($msgId);
			return TRUE;
		} else {
			return $CI->session->flashdata($msgId);
		}
	} else {
		return FALSE;
	}
}  /* End of getMessage */






/*   End of file funcoes_helper.php  */
/*   Location: ./application/helpers/funcoes_helper.php  */