<?php

defined('BASEPATH') OR exit('No direct script access allowed');

switch ($tela) {
	case login:
		echo 'Tela de login';
	break;
	
	default:
		echo '<div class="alert alert-danger"><p>Tela Inexistente</p></div>';
	break;
}