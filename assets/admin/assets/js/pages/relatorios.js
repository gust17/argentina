var graphData = '';
var graphTipos = '';

$.ajax({
    url: baseURL + 'ajax/admin_relatorio_meios_pagamentos',
    type: 'GET',
    dataType: 'json',
    async: false,

    success: function (callback) {

        graphData = callback.dados;
        graphTipos = callback.tipos;
    },

    error: function (message) {
        console.log('[Erro ao carregar gráfico de análise financeira]');
        console.log(message.responseText);
    }
});

options = {
    chart: {
        height: 339,
        type: "line",
        stacked: !1,
        toolbar: {
            show: !1
        }
    },
    stroke: {
        width: [0, 2, 4],
        curve: "smooth"
    },
    plotOptions: {
        bar: {
            columnWidth: "30%"
        }
    },
    colors: ["#34c38f"],
    series: graphData,
    fill: {
        opacity: [1, 1],
        gradient: {
            inverseColors: !1,
            shade: "light",
            type: "vertical",
            opacityFrom: .85,
            opacityTo: .55,
            stops: [0, 100, 100, 100]
        }
    },
    labels: graphTipos,
    markers: {
        size: 0
    },
    yaxis: {
        title: {
            text: "Quantidade"
        },
        labels: {
            formatter: function (value) {
                return value.toFixed(0);
            }
        }
    },
    tooltip: {
        shared: !0,
        intersect: !1,
        y: {
            formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) : e
            }
        }
    },
    grid: {
        borderColor: "#f1f1f1"
    }
};
(chart = new ApexCharts(document.querySelector("#meios_pagamenos"), options)).render();

var graphData = '';
var graphTipos = '';

$.ajax({
    url: baseURL + 'ajax/admin_relatorio_planos_investidos',
    type: 'GET',
    dataType: 'json',
    async: false,

    success: function (callback) {

        graphData = callback.dados;
        graphTipos = callback.tipos;
    },

    error: function (message) {
        console.log('[Erro ao carregar gráfico de análise financeira]');
        console.log(message.responseText);
    }
});

options = {
    chart: {
        height: 339,
        type: "line",
        stacked: !1,
        toolbar: {
            show: !1
        }
    },
    stroke: {
        width: [0, 2, 4],
        curve: "smooth"
    },
    plotOptions: {
        bar: {
            columnWidth: "30%"
        }
    },
    colors: ["#34c38f"],
    series: graphData,
    fill: {
        opacity: [1, 1],
        gradient: {
            inverseColors: !1,
            shade: "light",
            type: "vertical",
            opacityFrom: .85,
            opacityTo: .55,
            stops: [0, 100, 100, 100]
        }
    },
    labels: graphTipos,
    markers: {
        size: 0
    },
    yaxis: {
        title: {
            text: "Quantidade"
        },
        labels: {
            formatter: function (value) {
                return value.toFixed(0);
            }
        }
    },
    tooltip: {
        shared: !0,
        intersect: !1,
        y: {
            formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) : e
            }
        }
    },
    grid: {
        borderColor: "#f1f1f1"
    }
};
(chart = new ApexCharts(document.querySelector("#planos_investidos"), options)).render();

var graphData = '';
var graphTipos = '';

$.ajax({
    url: baseURL + 'ajax/admin_relatorio_retirada_meio',
    type: 'GET',
    dataType: 'json',
    async: false,

    success: function (callback) {

        graphData = callback.dados;
        graphTipos = callback.tipos;
    },

    error: function (message) {
        console.log('[Erro ao carregar gráfico de análise financeira]');
        console.log(message.responseText);
    }
});

options = {
    chart: {
        height: 339,
        type: "line",
        stacked: !1,
        toolbar: {
            show: !1
        }
    },
    stroke: {
        width: [0, 2, 4],
        curve: "smooth"
    },
    plotOptions: {
        bar: {
            columnWidth: "30%"
        }
    },
    colors: ["#34c38f"],
    series: graphData,
    fill: {
        opacity: [1, 1],
        gradient: {
            inverseColors: !1,
            shade: "light",
            type: "vertical",
            opacityFrom: .85,
            opacityTo: .55,
            stops: [0, 100, 100, 100]
        }
    },
    labels: graphTipos,
    markers: {
        size: 0
    },
    yaxis: {
        title: {
            text: "Quantidade"
        },
        labels: {
            formatter: function (value) {
                return value.toFixed(0);
            }
        }
    },
    tooltip: {
        shared: !0,
        intersect: !1,
        y: {
            formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) : e
            }
        }
    },
    grid: {
        borderColor: "#f1f1f1"
    }
};
(chart = new ApexCharts(document.querySelector("#meios_recebimento"), options)).render();

var graphData = '';
var graphTipos = '';

$.ajax({
    url: baseURL + 'ajax/admin_relatorio_dias_retirada',
    type: 'GET',
    dataType: 'json',
    async: false,

    success: function (callback) {

        graphData = callback.dados;
        graphTipos = callback.tipos;
    },

    error: function (message) {
        console.log('[Erro ao carregar gráfico de análise financeira]');
        console.log(message.responseText);
    }
});

options = {
    chart: {
        height: 339,
        type: "line",
        stacked: !1,
        toolbar: {
            show: !1
        }
    },
    stroke: {
        width: [0, 2, 4],
        curve: "smooth"
    },
    plotOptions: {
        bar: {
            columnWidth: "30%"
        }
    },
    colors: ["#34c38f"],
    series: graphData,
    fill: {
        opacity: [1, 1],
        gradient: {
            inverseColors: !1,
            shade: "light",
            type: "vertical",
            opacityFrom: .85,
            opacityTo: .55,
            stops: [0, 100, 100, 100]
        }
    },
    labels: graphTipos,
    markers: {
        size: 0
    },
    yaxis: {
        title: {
            text: "Quantidade"
        },
        labels: {
            formatter: function (value) {
                return value.toFixed(0);
            }
        }
    },
    tooltip: {
        shared: !0,
        intersect: !1,
        y: {
            formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) : e
            }
        }
    },
    grid: {
        borderColor: "#f1f1f1"
    }
};
(chart = new ApexCharts(document.querySelector("#saques_dia"), options)).render();