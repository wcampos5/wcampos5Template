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
	
	
	
	case 'editar':
	
		$pageId = $this->uri->segment(3);
	
		//Verifica se existe uma pagina para trocar a senha
		if ($pageId == NULL) {
			setMessage('msgError', 'Selecione uma pagina para modificar', 'error');
			redirect('pagina/gerenciar');
		} // ./End of $userIdSegment == NULL
		?>
		<div class="col-sm-12 col-md-12 col-lg-12 ">
		<?php	
						
		$query = $this->page->getById($pageId)->row();
						
						
		//
		echo '<div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">';
		//Imprimi o breadcrumb
		echo breadcrumb();
		echo form_open(current_url(), array('class'=>'form-group login-form' ));
		echo '<fieldset>';
		echo '<legend>Alterar página</legend>';
		//Mostra erros de validação, caso exista
		showFormErrors();
		//Verifica se tem alguma mensagem flashdata setada
		getMessage('msgOK');
		getMessage('msgError');
	
	
		echo form_label('Título');
		echo form_input(array('name'=>'title', 'class'=>'form-control', 'placeholder'=>'Título da Página'), set_value('title', $query->title), 'autofocus');
		echo form_label('Slug');
		echo form_input(array('name'=>'slug', 'class'=>'form-control', 'placeholder'=>'Manter em branco caso não saiba  do que ser trata'), set_value('slug', $query->slug));
		
		//Dispara o modal através do botão
		echo form_button('', 'Inserir Imagem', array(
				'class="btn btn-info btn-lg" id="btnInsertImage"'
		));
		
		
		
		
		echo anchor('midia/cadastrar','Updaload de Imagens','class="btn btn-default btn-sm btn-secondary" target="_blank"');
		echo "</p>";
		
		//Inclui o arquivo insertimg
		includeFile('insertimg', 'includes', TRUE);
		
		echo form_label('Conteúdo');
		echo form_textarea(array('name'=>'content', 'class'=>'form-control htmleditor','rows'=>20), set_value('content', toHtml($query->content), FALSE));
		
		echo anchor('page/gerenciar', 'Cancelar', array('class'=>'btn btn-md btn-danger'));
		
		echo form_submit(array('name'=>'editar', 'class'=>'bnt btn-primary btn-md pull-right btn-submit'), 'Alterar página');
		
		echo form_hidden('pageID', $query->pageId);
	
		echo '</fieldset>';
		echo form_close();
							
							echo '</div>';
					
							
						
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