<template>
  <div id="app">
      <line-chart :data="chartData"></line-chart>
  </div>
</template>

<script>
import Vue from 'vue'
import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'
 
Vue.use(Chartkick.use(Chart))
export default {
  name: 'app',
  data(){
    return{
      chartData: {
        '2017-05-13':2,
        '2017-05-14':5,
        '2017-05-15':4
      }
    }
  }
}
</script>
