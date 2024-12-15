'use strict'
$(function () {
  transactiondata()
})

function transactiondata() {
  $.ajax({
    url: domain + domainpath + '/pos-admin/transaction-data',
    type: 'GET',
    data: '',
    success: function (data) {
      am4core.useTheme(am4themes_animated)
      var chart = am4core.create('transactiondata', am4charts.PieChart)

      var sell = data.sell.map(function (e) {
        return e.jumlah
      })

      var purchase = data.purchase.map(function (e) {
        return e.jumlah
      })

      var p_return = data.purchase_return.map(function (e) {
        return e.jumlah
      })

      var adjustment = data.adjustment.map(function (e) {
        return e.jumlah
      })

      var transfer = data.transfer.map(function (e) {
        return e.jumlah
      })
      
      chart.data = [
        {
          country: 'Sell',
          litres: sell,
        },
        {
          country: 'Purchase',
          litres: purchase,
        },
        {
          country: 'Stock Transfer',
          litres: transfer,
        },
        {
          country: 'Adjustment',
          litres: adjustment,
        },
        {
          country: 'Purchase Return',
          litres: p_return,
        },
      ]

      // Set inner radius
      chart.innerRadius = am4core.percent(50)

      // Add and configure Series
      var pieSeries = chart.series.push(new am4charts.PieSeries())
      pieSeries.dataFields.value = 'litres'
      pieSeries.dataFields.category = 'country'
      pieSeries.slices.template.stroke = am4core.color('#fff')
      pieSeries.slices.template.strokeWidth = 2
      pieSeries.slices.template.strokeOpacity = 1
      pieSeries.labels.template.fill = am4core.color('#8e8da4')

      // This creates initial animation
      pieSeries.hiddenState.properties.opacity = 1
      pieSeries.hiddenState.properties.endAngle = -90
      pieSeries.hiddenState.properties.startAngle = -90
    },

    cache: false,
    contentType: false,
    processData: false,
  })
}
