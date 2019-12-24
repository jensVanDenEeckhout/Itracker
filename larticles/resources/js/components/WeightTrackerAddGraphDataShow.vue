

<style scoped>
    .test{
          display: grid;
          grid-template-columns: 100%;
          grid-gap: 30px;
          margin:30px;
          border-style: 1px solid;

    }
    .weightStatsAndAdd {
      display: grid;
      grid-template-columns: auto auto;
      grid-gap: 30px;
      margin:30px;
      align-items: center;
    }

    .table{
    }
</style>

<template>
  <div id="app" class="test">
         <h2 style="text-align:center;">Weight tracker</h2>
      <line-chart :data="d1" :min="min" :max="max"></line-chart>

    <div class="weightStatsAndAdd">
        <form @submit.prevent="addweightRecord1" class="mb-3"> 
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Date" v-model="weightRecord.date">
            </div>

             <div class="form-group">
                <input type="text" class="form-control" placeholder="Weight" v-model="weightRecord.weight"></textarea>
            </div>

            <button type="submit" class="btn btn-success btn-block">Save</button>   
        </form>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>weight</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="weightRecord in weightRecords" v-bind:key="weightRecord.id"> 
               <td>{{ weightRecord.date }}</td> 
               <td>{{ weightRecord.weight }}</td>  
            </tr>
           </tbody>
        </table>
    </div>


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
            min: 200,
            max: 1,
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
        addweightRecord1(){
            if(this.edit === false){
                // add
                fetch('api/weightRecord1', {
                    method: 'post',
                    body: JSON.stringify(this.weightRecord),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert('weightRecord Added');
                    this.fetchWeightRecords();
                })
                .catch(err => console.log(err));
            }else{
            }
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

                    if(this.min > this.weightRecords[i].weight){
                        this.min =  this.weightRecords[i].weight;
                    }
                    if(this.max < this.weightRecords[i].weight){
                        this.max =  this.weightRecords[i].weight;
                    }                    
            }
            console.log(d2);
            this.d1 = d2;
        }
    }
};
</script>