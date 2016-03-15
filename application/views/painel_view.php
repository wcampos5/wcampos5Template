<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE-Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title><?php if(isset($titulo)): ?>{titulo} | <?php endif; ?>{defaultTitle}</title>
		
		{cssInclude}
		{jsInclude}
		
	</head>

	
	
	
	
	<body>
		<div class="container">
			<?php 
			//Verifica se esta passando o redirecionamento como FALSE logado e monta a interface do painel
			//TODO: Acertar colnas abaixo para outras interfaces
			if (isLogged(FALSE)) { ?>
				<div class="row">
					<div class="col-lg-8">
						<a href="<?php echo base_url('painel'); ?>"><h1>Painel ADM</h1></a>
					</div>
					
					<div class="col-lg-4">
						<p class="pull-right">
							Bem vindo <strong><?php echo $this->session->userdata('name'); ?></strong>!
						</p>
						
						<p class="pull-right">
							<?php
							//Altercao de senha
							echo anchor('usuarios/alterar_senha/' . $this->session->userdata('userId'), 'Alterar Senha', 'class="btn btn-primary"'); 
							//Logoff
							echo anchor('usuarios/logoff', 'Sair', 'class="btn btn-danger"');
							?>
							
						</p>
					</div>
				
				</div> <!-- ./End of row header -->
				
				<!-- **** NavBar *** -->
				
				<nav class="navbar navbar-inverse">
				  <div class="container-fluid">
				    <div class="navbar-header">
				      <a class="navbar-brand" href="#">WebSiteName</a>
				    </div>
				    <ul class="nav navbar-nav">
				      <li class="active"><?php echo anchor('painel', 'Inicio');?></li>
				      <li class="dropdown">
				      	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Usuários
				        <span class="caret"></span></a>
				        <ul class="dropdown-menu">
				          <li><?php echo anchor('usuarios/cadastrar', 'Cadastrar');?></li>
				          <li><?php echo anchor('usuarios/gerenciar', 'Gerenciar');?></li>
				           
				        </ul>
				      </li>
				      <li class="dropdown">
				      	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Auditoria
				        <span class="caret"></span></a>
				        <ul class="dropdown-menu">
				       		<li><?php echo anchor('auditoria/gerenciar', 'Gerenciar');?></li>
				           
				        </ul>
				      </li>
				      <li class="dropdown">
				      	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Midia
				        <span class="caret"></span></a>
				        <ul class="dropdown-menu">
				       		<li><?php echo anchor('midia/cadastrar', 'Cadastrar');?></li>
				       		<li><?php echo anchor('midia/gerenciar', 'Gerenciar');?></li>
				           
				        </ul>
				      </li>
				      </li>
				      <li class="dropdown">
				      	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Páginas
				        <span class="caret"></span></a>
				        <ul class="dropdown-menu">
				       		<li><?php echo anchor('pagina/cadastrar', 'Cadastrar');?></li>
				       		<li><?php echo anchor('pagina/gerenciar', 'Gerenciar');?></li>
				           
				        </ul>
				      </li>
				      <li><a href="#">New</a></li> 
				    </ul>
				  </div>
				</nav> <!-- **** ./NavBar *** -->
				
				
			<?php } ?>
		
			<div class="row">
			
			
			
				{conteudo}
				
			</div>
			
			<div class="row">
				<div class="col-lg-12 text-center">
					{footer}
				</div>
				
			</div>
		</div>
		
		
	
	</body>
</html>