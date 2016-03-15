<?php

defined('BASEPATH') OR exit('No direct script access allowed');

switch ($screen) {
	
	case 'cadastrar':
	
		echo '<div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">';
		//Imprimi o breadcrumb
		echo breadcrumb();
		echo form_open('page/cadastrar', array('class'=>'form-group login-form' ));
		echo '<fieldset>';
		echo '<legend>Cadastro de páginas</legend>';
		//Mostra erros de validação, caso exista
		showFormErrors();
		//Verifica se tem alguma mensagem flashdata setada
		getMessage('msgOK');
		getMessage('msgError');
	
	
		echo form_label('Título');
		echo form_input(array('name'=>'title', 'class'=>'form-control', 'placeholder'=>'Título da Página'), '', 'autofocus');
		echo form_label('Slug');
		echo form_input(array('name'=>'slug', 'class'=>'form-control', 'placeholder'=>'Manter em branco caso não saiba  do que ser trata'));
		echo form_label('Conteúdo');
		echo form_textarea(array('name'=>'content', 'class'=>'form-control htmleditor','rows'=>20, 'placeholder'=>'Manter em branco caso não saiba  do que ser trata'), set_value('content'));
		
		echo anchor('page/gerenciar', 'Cancelar', array('class'=>'btn btn-md btn-danger'));
		
		echo form_submit(array('name'=>'cadastrar', 'class'=>'bnt btn-primary btn-md pull-right btn-submit'), 'Publicar página');
		
	
		echo '</fieldset>';
		echo form_close();
	
	break;
		
	case 'gerenciar':
?>
		<script type="text/javascript">
			$(function(){
				$('.confirmadelecao').click(function(){
					if (confirm("Deseja realmente excluir este registro?\nEsta operação não poderá ser desfeita!!!")) return true; else 
						return false;
				});

				//
				$('input').click(function(){
					(this).select();
				});
			});
		</script>
		<div class="col-sm-12 col-md-12 col-lg-12 ">
		<?php
		//Imprimi o breadcrumb
		echo breadcrumb();
			getMessage('msgOK');
			getMessage('msgError');
			
		?>
			<table class="table table-striped data-table">
			  
			  <thead>
			  	<tr>
			  		<th class="text-center">Nome</th>
			  		<th class="text-center">Link</th>
			  		<th class="text-center">Miniatura</th>
			  		<th class="text-center">Ações</th>
			  	</tr>
			  </thead>
			  
			  <tbody>
<?php 
				$query = $this->midia->getAll()->result(); //Trás os dados da tabela
				
				foreach ($query as $item){
					echo '<tr>';
						printf('<td>%s</td>', $item->name);
						printf('<td><input type="text" value="%s" size="85" /></td>', base_url("uploads/$item->file"));
						printf('<td>%s</td>', thumb($item->file));
						printf('<td class="text-center">%s%s%s</td>', anchor("uploads/$item->file", ' ', array('class'=>'glyphicon glyphicon-search', 'title'=>'Visualizar', 'target'=>'_blank')) . nbs(4),
								anchor("media/editar/$item->midiaId", ' ', array('class'=>'glyphicon glyphicon-edit', 'title'=>'Editar')). nbs(8),
								anchor("usuarios/excluir/$item->midiaId", ' ', array('class'=>'confirmadelecao glyphicon glyphicon-trash', 'title'=>'Deletar')));
						
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