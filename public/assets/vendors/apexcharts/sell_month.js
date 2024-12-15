"use strict";
$(function () {
    sellMonth();
});

function sellMonth() {
    $.ajax({
        url: domain + domainpath + "/pos-admin/sell-month",
        type: 'GET',
        data: '',
        success: function (data) {
            var date = data.selling.map(function (e) {
                return e.date;
            });
            var sell = data.selling.map(function (e) {
                return e.total;
            });

            var options = {
                series: [{
                    name: "Penjualan",
                    data: sell
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: 'Penjualan 30 Hari Terakhir',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: date,
                },
                tooltip: {
                  y: {
                      formatter: function (val) {
                          return moneyformatter + " " + formatRupiah(val.toString()) + " "
                      }
                  }
              }
            };

            var chart = new ApexCharts(document.querySelector("#sellMonth"), options);
            chart.render();
        },

        cache: false,
        contentType: false,
        processData: false
    });
}
