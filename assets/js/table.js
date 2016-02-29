$(document).ready(function(){
	$(".data-table").dataTable({
		/* Tradução de campos */
		"oLanguage": {
			"sSearch": "Pesquisar:",
			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros"
		},
		"sScrollY": "400px",
		"sScrollX": "100%",
		"sScrollXInner": "100%",
		"bPaginate": false,
		"aaSorting": [[0,"asc"]]
	});
	/*TODO: Re-definir area de search no inicio da tabela */
	$(".dataTables_filter").addClass('row');
	$(".dataTables_filter label").first().focus().addClass('col-lg-12');
});