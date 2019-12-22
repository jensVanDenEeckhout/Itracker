<template>
  <div id="app">
    <img alt="Vue logo" src="./assets/logo.png">


  <line-chart :data="chartData"></line-chart>

<pie-chart :data="[['Nokia',150],['Samsung',120]]"></pie-chart>


<button @click="updateChart"> Update Data</button>
  </div>
</template>

<script>

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
  },
  methods:{
    updateChart(){
      this.chartData = {
        '2017-05-13':8,
        '2017-05-14':15,
        '2017-05-15':11       
      }
    }
  }
}