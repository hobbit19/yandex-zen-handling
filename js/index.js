$(document).ready(function () {

    $('ul li').click(function () {
        $('ul li').removeClass();
        $(this).find('input').attr("checked", true);
        $(this).attr("class", "active");
        $.ajax({
            url: 'getdata.php',
            data: {login: $(this).find('input').val()},
            dataType: 'json'
        })
            .done(function (e) {
                showData(e);
            });
    });

    function showData(data) {
        $("#lastFs").html(data.last.fs);
        $("#lastV").html(data.last.v);
        $("#lastVte").html(data.last.vte);
        $("#interest").html(data.interest);
        $("#quality").html(data.quality);

        Highcharts.setOptions({
            global : {
                useUTC : false
            }
        });
        Highcharts.chart('container', {
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Статистика показов, просмотров и дочитываний'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Кликните и потяните область показа для увеличения' : 'Щипните график для увеличения'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Количество'
                }
            },
            legend: {
                enabled: true
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [
                {
                    type: 'area',
                    name: 'Лента',
                    data: data.fs
                },
                {
                    type: 'area',
                    name: 'Просмотры',
                    data: data.v
                },
                {
                    type: 'area',
                    name: 'Дочитывания',
                    data: data.vte
                }
            ]
        });
    }

    $('input[name=login]:first').trigger('click');
});