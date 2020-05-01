<template>
  <div id="app">
      <h1> Day Records</h1>

        <form @submit.prevent="addDay" class="mb-3"> 
             <div class="form-group">
                <input type="text" class="form-control" placeholder="Date" v-model="day.date">
                <input type="text" class="form-control" placeholder="Task Id" v-model="day.task_id">
                <input type="text" class="form-control" placeholder="Task Value" v-model="day.task_value">
            </div>

            <button type="submit" class="btn btn-success btn-block">Save</button>   
        </form>

        <table class="table table-striped">
          <thead>
            <tr>
                <th>day Id</th>
                <th>date</th>
                <th>task id</th>
                <th>task value</th>  
            </tr>
          </thead>
          <tbody>
            <tr v-for="day in days" v-bind:key="day.id">
                <td>{{ day.id }}</td>                   
                <td>{{ day.date }}</td>  
                <td>{{ day.task_id }}</td>  
                <td>{{ day.task_value }}</td>  
            </tr>
           </tbody>
        </table>
  </div>


</template>

<style scoped>

h1 {
    color:red;
}</style>

<script>
import Vue from 'vue'

export default {
    name: 'app',
    data(){
        return {
            day: {
                id: '',
                date: '',
                task_id: '',
                task_value: ''
            },
            days: [],
        };
    },
    created(){
        this.fetchDays();
    },
    methods: {
        fetchDays(page_url){
            let vm = this;
            page_url = page_url || '/api/days';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.days = res.data;
                //this.chartData = res.data;
                
            })
            .catch( err => console.log(err));
        },       
        addDay(){
            // add
            fetch('api/addDay', {
                method: 'post',
                body: JSON.stringify(this.day),
                headers: {
                    'content-type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                alert('day Added');
                this.fetchDays();
            })
            .catch(err => console.log(err));

        }
    }
};
</script>