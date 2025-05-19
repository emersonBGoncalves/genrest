$(function () {
	var startDate = Date.UTC(2021, 0, 17);
	var data_atual = new Date();
	var hora_atual = data_atual.getHours();
	var dia_atual = data_atual.getDate();

	// Formatando grafico de usuario por dia
	var string_usuario_dia = "[";
	for (var i = 0; i < Object.keys(json_usuario_dia).length; i++) {
		var char = "";
		if (string_usuario_dia != "[")
			char = ",";

		string_usuario_dia += char + '{"name":"' + json_usuario_dia[i].usuario + '" ,"y":' + json_usuario_dia[i].dados + ' ,"drilldown":"' + json_usuario_dia[i].usuario + '"}';
	}
	string_usuario_dia += "]";

	string_usuario_dia = JSON.parse(string_usuario_dia);
	// Fim da formatação grafico de usuario por dia

	// Formatando grafico de usuario por mes
	var string_usuario_mes = "[";
	for (var i = 0; i < Object.keys(json_usuario_mes).length; i++) {
		var char = "";
		if (string_usuario_mes != "[")
			char = ",";

		string_usuario_mes += char + '{"name":"' + json_usuario_mes[i].usuario + '" ,"y":' + json_usuario_mes[i].dados + ' ,"drilldown":"' + json_usuario_mes[i].usuario + '"}';
	}
	string_usuario_mes += "]";

	string_usuario_mes = JSON.parse(string_usuario_mes);
	// Fim da formatação grafico de usuario por mes

	$('#chart_uso_dia').highcharts({
		chart: {
			type: 'areaspline',
			backgroundColor: "transparent"
		},
		title: {
			text: null,
		},
		legend: {
			enabled: true,
			itemHoverStyle: { color: "#0984e3" },
			itemStyle: { color: "#a2a3b7", cursor: "pointer", textOverflow: "ellipsis" }
		},
		title: {
			text: 'Usos hoje'
		},
		tooltip: {
			headerFormat: '',
			pointFormat: '<b>Quantidade: {point.y}</b><br/>'
		},
		xAxis: {
			type: 'datetime',
			tickInterval: 3600 * 1000,
			labels: {
				formatter: function () {
					var ret = Highcharts.dateFormat('%H:%M', this.value);
					if (this.value > startDate && /00:00/.test(ret)) {
						ret = '23:59';
					}
					return ret;
				},
			},
		},
		yAxis: {
			endOnTick: false,
			title: {
				text: null,
			},
			labels: {
				formatter: function () {
					return this.value;
				}
			},
			gridLineColor: '#222a35'
		},
		plotOptions: {
			area: {
				fillOpacity: 0.5
			},
			series: {
				color: "#0984e3",
				pointStart: startDate,
				pointInterval: 3600 * 1000
			}
		},
		credits: {
			enabled: false
		},
		series: [{
			name: 'Usos por hora',
			data: []
		}]
	});

	//var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
	var date = new Date();

	$('#chart_uso_mes').highcharts({
		chart: {
			type: 'areaspline',
			backgroundColor: "transparent"
		},
		title: {
			text: null,
		},
		legend: {
			enabled: true,
			itemHoverStyle: { color: "#0984e3" },
			itemStyle: { color: "#a2a3b7", cursor: "pointer", textOverflow: "ellipsis" }
		},
		title: {
			text: 'Usos por mês'
		},
		xAxis: {
			type: 'datetime'
		},
		yAxis: {
			endOnTick: false,
			title: {
				text: null,
			},
			labels: {
				formatter: function () {
					return this.value;
				}
			},
			gridLineColor: '#222a35'
		},
		

		plotOptions: {
			area: {
				fillOpacity: 0.5
			},
			series: {
				color: "#0984e3",
				pointStart: Date.UTC(date.getFullYear(), date.getMonth(), 1),
				pointInterval: 24 * 3600 * 1000 // one day
			}
		},
		credits: {
			enabled: false
		},
		series: [{
			name: 'Usos por mês',
			data: [0, 1, 4, 4, 16, 2, 3, 7, 9, 4, 0, 7]
		}]
	});

	$('#uso_usuario_dia').highcharts({
		chart: {
			type: 'column',
			backgroundColor: "transparent"
		},
		title: {
			text: 'Uso por usuário hoje'
		},
		xAxis: {
			type: 'category'
		},
		yAxis: {
			title: {
				text: null
			},
			gridLineColor: '#222a35'
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					color: "#fff"
				}
			}
		},

		tooltip: {
			headerFormat: '',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
		},

		series: [
			{
				name: "Usuários",
				colorByPoint: true,
				data: string_usuario_dia
			}
		]
	});

	$('#uso_usuario_mes').highcharts({
		chart: {
			type: 'column',
			backgroundColor: "transparent"
		},
		title: {
			text: 'Uso por usuário no mês'
		},
		xAxis: {
			type: 'category'
		},
		yAxis: {
			title: {
				text: null
			},
			gridLineColor: '#222a35'
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					color: "#fff"
				}
			}
		},

		tooltip: {
			headerFormat: '',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
		},

		series: [
			{
				name: "Usuários",
				colorByPoint: true,
				data: string_usuario_mes
			}
		]
	});

	Highcharts.setOptions({
		lang: {
			months: [
				'Janeiro', 'Fevereiro', 'Março', 'Abril',
				'Maio', 'Junho', 'Julho', 'Ago',
				'Setembro', 'Outubro', 'Novembro', 'Dezembro'
			],
			shortMonths: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
			weekdays: [
				'Domingo', 'Segunda', 'Terça', 'Quarta',
				'Quinta', 'Sexta', 'Sábado'
			]
		}
	});

	// Formatando grafico de uso por dia
	string_uso_dia = [];
	var achou_dia = false;
	var tem_mais_que_zero_dia = false;
	for (var i = 0; i <= hora_atual; i++) {
		achou_dia = false
		for (var i2 = 0; i2 < Object.keys(json_uso_dia).length; i2++) {
			if (parseInt(json_uso_dia[i2].id) == parseInt(i)) {
				achou_dia = true;

				if (parseInt(json_uso_dia[i2].dados) > 0)
					tem_mais_que_zero_dia = true;
				string_uso_dia.push(parseInt(json_uso_dia[i2].dados));
			}
		}

		if (!achou_dia)
			string_uso_dia.push(0);
	}

	var chart_uso_dia = $('#chart_uso_dia').highcharts();
	chart_uso_dia.series[0].setData(string_uso_dia);

	// Fim da formatação grafico de uso por dia

	// Formatando grafico de uso por mes
	string_uso_mes = [];
	var achou_mes = false;
	var tem_mais_que_zero_mes = false;
	for (var i = 1; i <= dia_atual; i++) {
		achou_mes = false;
		for (var i2 = 0; i2 < Object.keys(json_uso_mes).length; i2++) {
			if (parseInt(json_uso_mes[i2].id) == parseInt(i)) {
				achou_mes = true;

				if (parseInt(json_uso_mes[i2].dados) > 0)
					tem_mais_que_zero_mes = true;
				string_uso_mes.push(parseInt(json_uso_mes[i2].dados));
			}
		}

		if (!achou_mes)
			string_uso_mes.push(0);
	}

	var chart_uso_mes = $('#chart_uso_mes').highcharts();
	chart_uso_mes.series[0].setData(string_uso_mes);

	// Fim da formatação grafico de uso por mes
	if (!tem_mais_que_zero_mes)
		chart_uso_mes.yAxis[0].setExtremes(0, 10);

	if (!tem_mais_que_zero_dia)
		chart_uso_dia.yAxis[0].setExtremes(0, 10);
});