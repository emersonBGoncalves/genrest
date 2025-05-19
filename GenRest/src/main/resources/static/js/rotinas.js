$(function () 
{
	$('[rel="tooltip"]').tooltip();

	$(".remover_alert").click(function () {
		$(this).parent(".alert").hide("show");
		clearInterval(interval);
	});

	$("body").click(function () {
		$(this).parent(".alert").hide("show");
	});

	if ($('.alert').is(':visible'))
	{
		var start = new Date;
		var timer = 29;
		var interval = setInterval(function () 
		{
			timer = 29 - (new Date - start) / 1000;
			$('.alert_timer').text(parseInt(timer));

			if (parseInt(timer) == 0)
			{
				$('.alert').fadeOut('hide');
				clearInterval(interval);
			}
		}, 1000);
	}

	$('#detalharModal').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		
		var dados = button.data('dados');
		
		var modal = $(this);

		modal.find('.modal-body').html('<strong>' + JSON.stringify(dados, null, 4) + '</strong>');
	});

	$(".plano").click(function () {
		if ($(this).hasClass("plano_no_click"))
			return;

		$(".plano").each(function () {
			$(this).removeClass("plano_selecionado");
		});

		$(this).addClass("plano_selecionado");
		$(".plano_valor").val($(this).attr('data-valor'));

		if ($(this).attr('data-valor') == 0) {
			$(".configuracao_amd").addClass("oculto");
			$(".configuracao_amd_config").addClass("oculto");
		}
		else if ($(this).attr('data-valor') == 3 || $(this).attr('data-valor') == 1 || $(this).attr('data-valor') == 11) {
			$(".configuracao_amd").removeClass("oculto");
			$(".configuracao_amd_config").removeClass("oculto");
		}
		else {
			$(".configuracao_amd").addClass("oculto");
			$(".configuracao_amd_config").removeClass("oculto");
		}
	});

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#img_file').css('background-image', 'url(' + e.target.result + ')');
			}

			reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	$("#arquivo").change(function () {
		readURL(this);
	});

	$("#img_file").click(function () {
		$("#arquivo").click();
	});

	$("#img_file_clip").click(function () {
		$("#arquivo").click();
	});

	$("#cpfcnpj").keydown(function () {
		try {
			$("#cpfcnpj").unmask();
		} catch (e) { }

		var tamanho = $("#cpfcnpj").val().length;

		if (tamanho < 11) {
			$("#cpfcnpj").mask("999.999.999-99");
		} else {
			$("#cpfcnpj").mask("99.999.999/9999-99");
		}

		// ajustando foco
		var elem = this;
		setTimeout(function () {
			// mudo a posição do seletor
			elem.selectionStart = elem.selectionEnd = 10000;
		}, 0);
		// reaplico o valor para mudar o foco
		var currentValue = $(this).val();
		$(this).val('');
		$(this).val(currentValue);
	});

	$("#estadual").mask("999.999.999/9999");

	$("#telefone").mask("(99) 99999-9999");

	$(".exibir_doc").click(function(){

		if ($('.' + $(this).attr('data-funcao')).is(":visible"))
		{
			$('.' + $(this).attr('data-funcao')).hide('slow');
			$(this).addClass('bxs-down-arrow-alt');
			$(this).removeClass('bxs-up-arrow-alt');
		}
		else
		{
			$('.' + $(this).attr('data-funcao')).show('slow');
			$(this).removeClass('bxs-down-arrow-alt');
			$(this).addClass('bxs-up-arrow-alt');
		}
	});
});
