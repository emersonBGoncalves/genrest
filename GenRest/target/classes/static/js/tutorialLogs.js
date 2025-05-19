$(function () {
	var qtd = $(".tutorial").length;
	var atual = 0;
	var anterior = 'nao';
	var jsonData = {};

	jsonData[0] = "Listagem de todos os Logs de requisições registrados";
	jsonData[1] = "Coluna que contém o identificador do LOG";
	jsonData[2] = "Coluna que contém o usuario que realizou a requisição";
	jsonData[3] = "Coluna que contém a data exata em que foi realizada a requisição";
	jsonData[4] = "Coluna que contém a um botão de detalhes que abrirá um modal com o corpo enviado na requisição";

	$("#help").click(function () {
		atual = 0;
		anterior = 'nao';
		$(".box_tutorial").show();
		$("html, body").css("overflow", "hidden");
		$("#proximo").html("Próximo");
		proximo();
	});

	$("#proximo").click(function () {
		proximo();
	});

	function proximo() {
		if (anterior != 'nao') {
			$(".tutorial").eq(anterior).css("opacity", ".2");
		}

		if (atual == qtd - 1) {
			$("#proximo").html("Finalizar");
		}
		else if (atual == qtd) {
			$(".tutorial").css("opacity", "1");
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			$(".box_tutorial").hide();
			$("html, body").css("overflow", "visible");
			$("#tbody").show();
			$(".dataTables_length").show();
			$(".dataTables_filter").show();
			$(".dataTables_info").show();
			$(".dataTables_paginate").show();
			return false;
		}

		if (atual == 1) {
			$(".tutorial").css("opacity", ".01");
			$("#tbody").hide();
			$(".dataTables_length").hide();
			$(".dataTables_filter").hide();
			$(".dataTables_info").hide();
			$(".dataTables_paginate").hide();
		}

		$(".tutorial").eq(atual).css("opacity", "1");
		if ($(".tutorial").eq(atual).attr("data-pai-tutorial") != null)
			$("." + $(".tutorial").eq(atual).attr("data-pai-tutorial")).css("opacity", "1");

		$('html, body').animate({ scrollTop: $(".tutorial").eq(atual).offset().top - 50 }, 'fast');
		$("#msg_tutorial").html(jsonData[atual]);

		$(".box_tutorial").animate({ top: $(".tutorial").eq(atual).offset().top + $(".tutorial").eq(atual).outerHeight() }, 'fast');

		anterior = atual;
		atual = atual + 1;
	}
});