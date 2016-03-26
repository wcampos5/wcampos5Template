  <script type="text/javascript">
$(document).ready(function(){
    $("#btnInsertImage").click(function(){
        $("#myModal").modal();
    });

    $('.buscarImagem').click(function(){
		var destino = "<?php echo base_url('midia/getImages') ?>";
		var dados = $(".buscarTexto").serialize();
		$.ajax({
			type: "POST",
			url: destino,
			data: dados,
			success: function(retorno){
				$('.retorno').html(retorno);
			}
		});
    });

    $(".limparImagem").click(function(){
		$(".buscarTexto").val('');
		$(".retorno").html('');
    });
});
</script>
  
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Inserir Imagem</h4>
        </div>
        <div class="modal-body">
		          <?php echo form_input(array('name'=>'pesquisarImagem', 'class'=>'buscarTexto')); ?>
		       
		 
		          <?php echo form_button('', 'Buscar', 'class="buscarImagem btn btn-primary"'); ?>
		          <?php echo form_button('', 'Limpar', 'class="limparImagem btn btn-default"'); ?>
		       
	       
	       	
	       	<div class="retorno">&nbsp;</div>
	       	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
     </div>
      
    </div>