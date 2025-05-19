$(function () 
{
	var qtd = $(".tutorial").length;
	var atual = 0;
	var anterior = 'nao';
	var jsonData = {};

	jsonData[0] = "Mostra a quantidade de funções criadas pelo nosso sistema";
	jsonData[1] = "Mostra o plano contratado atualmente";
	jsonData[2] = "Mostra quantas requisições foram feitas no período atual do plano contratado";
	jsonData[3] = "Mostra o valor da fatura em relação as requisições que foram feitas no período atual do plano contratado";
	jsonData[4] = "Mostra a quantidade de requisições realizadas hoje desde as 00:00 até a hora atual";
	jsonData[5] = "Mostra a quantidade de requisições realizadas no mês atual desde o primeiro dia do mês até o dia atual";
	jsonData[6] = "Mostra a quantidade de usos de cada usuário hoje desde as 00:00 até a hora atual";
	jsonData[7] = "Mostra a quantidade de usos de cada usuário no mês atual desde o primeiro dia do mês até o dia atual";
	

	$("#help").click(function () {
		atual = 0;
		anterior = 'nao';
		$(".box_tutorial").show();
		$(".tutorial").css("opacity", ".01");
		$("html, body").css("overflow","hidden");
		$("#proximo").html("Próximo");
		proximo();
	});

	$("#proximo").click(function(){
		proximo();
	});

	function proximo()
	{
		if(anterior != 'nao')
		{
			$(".tutorial").eq(anterior).css("opacity", ".2");
		}

		if(atual == qtd - 1)
		{
			$("#proximo").html("Finalizar");
		}
		else if (atual == qtd)
		{
			$(".tutorial").css("opacity", "1");
			$('html, body').animate({ scrollTop: 0}, 'slow');
			$(".box_tutorial").hide();
			$("html, body").css("overflow", "visible");
			return false;
		}

		$(".tutorial").eq(atual).css("opacity", "1");
		$('html, body').animate({ scrollTop: $(".tutorial").eq(atual).offset().top - 50 }, 'fast');
		$("#msg_tutorial").html(jsonData[atual]);

		$(".box_tutorial").animate({ top: $(".tutorial").eq(atual).offset().top + $(".tutorial").eq(atual).outerHeight() }, 'fast');

		anterior = atual;
		atual = atual + 1;
	}
});