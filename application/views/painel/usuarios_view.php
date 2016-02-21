<?php

defined('BASEPATH') OR exit('No direct script access allowed');

switch ($screen) {
	case 'login':
		
		echo '<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 ">';
			echo form_open('usuarios/login', array('class'=>'form-group login-form' ));
				echo '<fieldset>';
					echo '<legend>Identificação</legend>';
						//Mostra erros de validação, caso exista
						showFormErrors();
						//Verifica se tem alguma mensagem flashdata setada
						getMessage('logoffOK');
						getMessage('loginNotOK');
						
					
						echo form_label('Usuário');
						echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'Email'), '', 'autofocus');
						
						echo form_label('Senha');
						echo form_password(array('name'=>'password','class'=>'form-control', 'placeholder'=>'Senha'));
						
						echo form_submit(array('name'=>'login', 'class'=>'bnt btn-primary btn-md pull-right btn-submit'), 'Entrar');
						//TODO: Melhorar espaçamento
						echo '<p>' . anchor('usuarios/nova_senha', 'Esqueci minha senha') . '<p>';
						
					echo '</fieldset>';
			echo form_close();


	
	break;
	
	default:
		echo '<div class="alert alert-danger"><p>Tela Inexistente</p></div>';
	break;
}