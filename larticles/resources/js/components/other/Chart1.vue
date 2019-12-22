
<template>
  <div class="container">
    <line-chart
      :chartdata="chartdata"
      :options="options"/>
  </div>
</template>


<script>
import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  name: Chart1,
  data: () => ({
    chartdata: {
      labels: ['January', 'February'],
      datasets: [
        {
          label: 'Data One',
          backgroundColor: '#f87979',
          data: [40, 20]
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  }),

  mounted () {
    this.renderChart(this.chartdata, this.options)
  }
}
</script>