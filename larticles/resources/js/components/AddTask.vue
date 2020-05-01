<template>
  <div id="app">
      <h1> Add Task</h1>
        <form @submit.prevent="addTask" class="mb-3"> 
             <div class="form-group">
                <input type="text" class="form-control" placeholder="Task" v-model="task.name">
            </div>

            <button type="submit" class="btn btn-success btn-block">Save</button>   
        </form>

          
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Id</th>
              <th>task name</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="task in tasks" v-bind:key="task.id">
               <td>{{ task.id }}</td>                   
               <td>{{ task.name }}</td>  
            </tr>
           </tbody>
        </table>


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
            task: {
                id: '',
                name: ''
            },
            tasks: [],
                select3: undefined,
    select3Options: ['A', 'B', 'C']
        };
    },
    created(){
        this.fetchTasks();
    },
    methods: {
        fetchTasks(page_url){
            let vm = this;
            page_url = page_url || '/api/tasks';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.tasks = res.data;
                this.greet();
                //this.chartData = res.data;
                
            })
            .catch( err => console.log(err));
        },       
        addTask(){
                // add
                fetch('api/addTask', {
                    method: 'post',
                    body: JSON.stringify(this.task),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert('task Added');
                    this.fetchTasks();
                })
                .catch(err => console.log(err));

        },

    }
};
</script>