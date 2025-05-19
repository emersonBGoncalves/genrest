$(function () {
	var qtd = $(".tutorial").length;
	var atual = 0;
	var anterior = 'nao';
	var jsonData = {};

	jsonData[0] = "Insira aqui seus dados cadastrais para sua identificação";
	jsonData[1] = "Seu nome ou nome da sua empresa (Obrigatório)";
	jsonData[2] = "Seu CPF ou CNPJ se for o caso (Obrigatório)";
	jsonData[3] = "Seu email para Login e envio de avisos (Obrigatório)";
	jsonData[4] = "Sua senha de Login, mantenha em branco caso não queira altera-la";
	jsonData[5] = "Sua inscrição estadual caso houver";
	jsonData[6] = "Seu telefone para uma melhor interação com nossa equipe";
	jsonData[7] = "Insira aqui seus dados do banco de dados MYSQL, esses dados serão usados para criar a sua API com todas as medidas de segurança tomadas para proteger seus dados";
	jsonData[8] = "O Host/IP de onde seu banco de dados esta hospedado";
	jsonData[9] = "O Database de onde iremos consultar as tabelas para criar as APIs";
	jsonData[10] = "O Usuário criado para nos conceder acesso aos dados";
	jsonData[11] = "A senha do Usuário de acesso";
	jsonData[12] = "Quais funções que deseja em sua API";
	jsonData[13] = "Os planos disponiveis para contratação, caso troque no meio de um período que ja esta em andamento, será alterado apenas no proximo período";

	$("#help").click(function () {
		atual = 0;
		anterior = 'nao';
		$(".box_tutorial").show();
		$(".tutorial").css("opacity", ".01");
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
			$(".btn-enviar").show();
			$("#editar_dados_db").show();
			return false;
		}

		$(".btn-enviar").hide();
		$("#editar_dados_db").hide();

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