<?php

defined('BASEPATH') OR exit('No direct script access allowed');

switch ($screen) {
	
	case 'cadastrar':
	
		echo '<div class="col-sm-12 col-sm-offset-0 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 ">';
		//Imprimi o breadcrumb
		echo breadcrumb();
		echo form_open_multipart('midia/cadastrar', array('class'=>'form-group login-form' ));
		echo '<fieldset>';
		echo '<legend>Carregar Mídia</legend>';
		//Mostra erros de validação, caso exista
		showFormErrors();
		//Verifica se tem alguma mensagem flashdata setada
		getMessage('msgOK');
		getMessage('msgError');
	
	
		echo form_label('Nome de exibição');
		echo form_input(array('name'=>'name', 'class'=>'form-control', 'placeholder'=>'Nome de exibição'), '', 'autofocus');
		echo form_label('Descrição');
		echo form_input(array('name'=>'description', 'class'=>'form-control', 'placeholder'=>'Descrição'));
		echo form_label('Arquivo');
		echo form_upload(array('name'=>'file', 'class'=>'form-control ', 'placeholder'=>'caminho/do/arquivo'), set_value('file'));	
	
		echo anchor('midia/gerenciar', 'Cancelar', array('class'=>'btn btn-md btn-danger'));
		
		echo form_submit(array('name'=>'cadastrar', 'class'=>'bnt btn-primary btn-md pull-right btn-submit'), 'Salvar Dados');
		
	
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
			
			//Verifica se recebeu o numero de itens a exibir
			$userIdSegment = $this->uri->segment(3);
			
			if ($userIdSegment == 'all') {
				$limite = 0;
			} else {
				$limite = 5;
			}// ./End of $totalToShow == NULL
			
			?>
			<p>Mostrando os ultimos <?php echo ($limite == 5)? '5 ' : ' ';?> registros, para ver tudo <?php echo anchor('auditoria/gerenciar/all', 'Clique Aqui');?></p>
			<table class="table table-striped data-table">
			  
			  <thead>
			  	<tr>
			  		<th class="text-center">Usuário</th>
			  		<th class="text-center">Data/Hora</th>
			  		<th class="text-center">Ação</th>
			  		<th class="text-center">Observação</th>
			  	</tr>
			  </thead>
			  
			  <tbody>
<?php 
				$query = $this->audit->getAll('5')->result(); //Trás os dados da tabela
				
				foreach ($query as $item){
					echo '<tr>';
						printf('<td>%s</td>', $item->email);
						printf('<td>%s</td>', date('d/m/Y H:i:s', strtotime($item->date_time)));
						printf('<td>%s</td>', '<span "data-toggle="tooltip" title="' . $item->query . '">' . $item->op . '</span>');
						//printf('<td>%s</td>', $item->op);
						printf('<td>%s</td>',$item->comment);
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