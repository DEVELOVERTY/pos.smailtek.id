'use strict'
$(function () {
  incomeExpense()
})

function incomeExpense() {
  $.ajax({
    url: domain + domainpath + '/pos-admin/income-expense',
    type: 'GET',
    data: '',
    success: function (data) {
      am4core.useTheme(am4themes_animated) 
      var chart = am4core.create('incomeExpense', am4charts.PieChart) 

      var income = data.income.map(function (e) {
        return e.jumlah
      })

      var expense = data.expense.map(function (e) {
        return e.jumlah
      })

      chart.data = [
        {
          country: 'Income',
          litres: income,
        },
        {
          country: 'Expense',
          litres: expense,
        },
      ]

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
