<?php

defined('BASEPATH') OR exit('No direct script access allowed');

switch ($screen) {
	
	case 'cadastrar':
	
		echo '<div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">';
		//Imprimi o breadcrumb
		echo breadcrumb();
		echo form_open('pagina/cadastrar', array('class'=>'form-group login-form' ));
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
			  		<th class="text-center">Título</th>
			  		<th class="text-center">Artigo</th>
			  		<th class="text-center">Resumo</th>
			  		<th class="text-center">Ações</th>
			  	</tr>
			  </thead>
			  
			  <tbody>
<?php 
				$query = $this->page->getAll()->result(); //Trás os dados da tabela
				
				foreach ($query as $item){
					echo '<tr>';
						printf('<td>%s</td>', $item->title);
						printf('<td>%s</td>', $item->slug);
						printf('<td>%s</td>', postSummary($item->content));
						printf('<td class="text-center">%s%s</td>', anchor("pagina/editar/$item->pageId", ' ', array('class'=>'glyphicon glyphicon-edit', 'title'=>'Editar')). nbs(8),
								anchor("pagina/excluir/$item->pageId", ' ', array('class'=>'confirmadelecao glyphicon glyphicon-trash', 'title'=>'Deletar')));
						
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