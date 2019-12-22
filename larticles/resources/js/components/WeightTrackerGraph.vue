<template>
  <div id="app">
      <line-chart :data="d1" :min="70" :max="80"></line-chart>
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
        return {
            d1: {},
            chartData: {
                '2017-05-13':2,
                '2017-05-14':5,
                '2017-05-15':4
            },
            weightRecords: [],
            weightRecord: {
                id: '',
                date: new Date().toISOString().slice(0,10),
                weight: ''
            },
            weightRecord_id: '',
            pagination: {},
            edit: false
        };
    },
    created(){
        this.fetchWeightRecords();
    },
    methods: {
        fetchWeightRecords(page_url){
            let vm = this;
            page_url = page_url || '/api/weightRecords';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.weightRecords = res.data;
                this.greet();
                //this.chartData = res.data;
                
            })
            .catch( err => console.log(err));
        },
        greet: function(){
            console.log('test');
            console.log(this.weightRecords);
            console.log(this.chartData);
            console.log(this.rows);

            var d2 = {};
            for(let i=0; i< this.weightRecords.length; i++){
                    var time = this.weightRecords[i].date;
                    var weight = this.weightRecords[i].weight;
                    d2[time] = weight;
            }
            console.log(d2);
            this.d1 = d2;


        }
    }
};
</script>