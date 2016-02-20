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
		
			<div class="row">
			
				{conteudo}
				
			</div>
		</div>
		
		{footer}
	
	</body>
</html>