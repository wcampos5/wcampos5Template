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
						echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'Email@site.com.br'), '', 'autofocus');
						
						echo form_label('Senha');
						echo form_password(array('name'=>'password','class'=>'form-control', 'placeholder'=>'Senha'));
						
						echo form_submit(array('name'=>'login', 'class'=>'bnt btn-primary btn-md pull-right btn-submit'), 'Entrar');
						//TODO: Melhorar espaçamento
						echo '<p>' . anchor('usuarios/nova_senha', 'Esqueci minha senha') . '<p>';
						
					echo '</fieldset>';
			echo form_close();


	
	break;
	
	case 'nova_senha':
	
		echo '<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 ">';
		echo form_open('usuarios/nova_senha', array('class'=>'form-group login-form' ));
		echo '<fieldset>';
		echo '<legend>Recuperação de Senha</legend>';
		//Mostra erros de validação, caso exista
		showFormErrors();
		//Verifica se tem alguma mensagem flashdata setada
		getMessage('msgOK');
		getMessage('msgError');
	
			
		echo form_label('Email');
		echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'Email@site.com.br'), '', 'autofocus');
	
		echo form_submit(array('name'=>'newPassword', 'class'=>'bnt btn-primary btn-md pull-right btn-submit'), 'Re-definir Senha');
		//TODO: Melhorar espaçamento
		echo '<p>' . anchor('usuarios/login', 'Efetuar Login') . '<p>';
	
		echo '</fieldset>';
		echo form_close();
	
		break;
		
		
		
	case 'cadastrar':
		
		echo '<div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">';
		echo form_open('usuarios/cadastrar', array('class'=>'form-group login-form' ));
		echo '<fieldset>';
		echo '<legend>Cadastrar novo Usuário</legend>';
		//Mostra erros de validação, caso exista
		showFormErrors();
		//Verifica se tem alguma mensagem flashdata setada
		getMessage('msgOK');
		getMessage('msgError');
		
				
		echo form_label('Nome Completo');
		echo form_input(array('name'=>'name', 'class'=>'form-control', 'placeholder'=>'Fulano de Tal'), '', 'autofocus');
		echo form_label('Email');
		echo form_input(array('name'=>'email', 'class'=>'form-control', 'placeholder'=>'Email@site.com.br'));
		echo form_label('Senha');
		echo form_password(array('name'=>'password', 'class'=>'form-control', 'placeholder'=>'Digite sua senha'));
		echo form_label('Redigite a senha');
		echo form_password(array('name'=>'password_repeat', 'class'=>'form-control', 'placeholder'=>'Re-digite sua senha'));
		echo form_checkbox(array('name'=>'adm'),'1') . ' Administrator?'. str_repeat('<br>', 2);
		
		
		
		echo form_submit(array('name'=>'addUser', 'class'=>'bnt btn-primary btn-md pull-right btn-submit'), 'Salvar Dados');
		echo anchor('usuarios/gerenciar', 'Cancelar', array('class'=>'btn btn-md btn-danger'));
		
		echo '</fieldset>';
		echo form_close();
		
		break;
		
	case 'gerenciar':
?>
		<div class="col-sm-12 col-md-12 col-lg-12 ">
			<table class="table table-striped data-table">
			  
			  <thead>
			  	<tr>
			  		<th>Nome</th>
			  		<th>Email</th>
			  		<th>Ativo | Admin</th>
			  		<th class="text-center">Ações</th>
			  	</tr>
			  </thead>
			  
			  <tbody>
<?php 
				$query = $this->usuarios->getAll()->result(); //Trás os dados da tabela
				
				foreach ($query as $item){
					echo '<tr>';
						printf('<td>%s</td>', $item->name);
						printf('<td>%s</td>', $item->email);
						printf('<td>%s | %s</td>', ($item->active==0) ? 'Não' : 'Sim', ($item->adm==0) ? 'Não' : 'Sim');
						printf('<td class="text-center">%s%s%s</td>', anchor("usuarios/editar/$item->userId", ' ', array('class'=>'glyphicon glyphicon-edit', 'title'=>'Editar')) . nbs(4),
								anchor("usuarios/alterar_senha/$item->userId", ' ', array('class'=>'glyphicon glyphicon-lock', 'title'=>'Trocar Senha')). nbs(8),
								anchor("usuarios/excluir/$item->userId", ' ', array('class'=>'glyphicon glyphicon-trash', 'title'=>'Deletar')));
					echo '</tr>';
				} // ./foreach $query
				
				
?>
			  
			  </tbody>
			  
			</table>
		
		</div>

<?php 
		
		break;
	
	default:
		echo '<div class="alert alert-danger"><p>Tela Inexistente</p></div>';
	break;
}