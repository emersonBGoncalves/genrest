$(function() {
	$('#exclusaoModal').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		
		var id = button.data('id');
		var descricaoUsuario = button.data('usuario');
		
		console.log(id + " " + descricaoUsuario);
		
		var modal = $(this);
		var form = modal.find('form');
		var action = form.data('url');
		if (!action.endsWith('/')) {
			action += '/';
		}
		form.attr('action', action + id);
		form.attr('method', 'DELETE');
		
		modal.find('.modal-body').html('Tem certeza que deseja excluir o token <strong>' + descricaoUsuario + '</strong>?');
	});
	
	
});