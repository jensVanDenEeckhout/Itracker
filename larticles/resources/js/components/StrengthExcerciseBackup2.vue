
<style>
    .fileContainer {
        overflow: hidden;
        position: relative;
    }
    
    .fileContainer [type=file] {
        cursor: inherit;
        display: block;
        font-size: 999px;
        filter: alpha(opacity=0);
        min-height: 21px;
        min-width: 100%;
        opacity: 0;
        position: absolute;
        right: 0;
        text-align: right;
        top: 0;
    }
    
    .fileContainer {
        background: #E3E3E3;
        float: left;
        padding: .5em;
        height: 21px;
    }
    
    .fileContainer [type=file] {
        cursor: pointer;
    }

    .divexcer{
      display:none;
    /* transition */
    }

    .exerciseRecord{
      display:grid;
      grid-template-columns: auto auto auto;
      grid-gap: 30px;
      margin:30px;
      align-items: center;
    }
</style>

<template>
  <div id="app">
    <div class="exerciseRecord">
      <div>
        <td>
          <select required id="dropDown" @change="onChange($event)">
            <option>Select</option>
            <option v-for="(muscleGroup,index) in muscleGroups"  v-bind:value="index">{{ muscleGroup }} </option>
          </select>
        </td>  

        <div class="divexcer">  
          <td>
            <select required class="dropDownSpecificExercise" >
              <option>Select </option>
              <option v-for="(muscleExcercise,index) in muscleExcercises">{{ muscleExcercise }}</option>
            </select>
          </td>  
        </div>  

        <table class="table">
            <thead>
                <tr>
                    <td><strong>Exercise </strong></td>
                    <td><strong>Repetitions</strong></td>
                    <td><strong>Weight</strong></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in rows">
                    <td>
                      <select required class="dropDownSpecificExercise" v-model="exerciseRecord.exercise" >
                        <option>Select</option>
                        <option v-for="muscleExcercise in muscleExcercises">{{ muscleExcercise }}</option>
                      </select>
                    </td> 

                    <td>
                      <select required class="setReps"  v-model="exerciseRecord.repetitions" >
                        <option>Select </option>
                        <option v-for="repetition in repetitions" v-bind:value="repetition">{{ repetition }}</option>
                      </select>
                    </td>  

                     <td>
                      <select required class="setWeight" v-model="exerciseRecord.weight" >
                        <option>Select </option>
                        <option v-for="repetition in repetitions">{{ repetition }}</option>
                      </select>
                    </td>  

                </tr>
            </tbody>
                                          <button class="btn-success"><a  v-on:click="saveRecord();" style="cursor: pointer">Save</a></button>

                     <button class="btn-danger"><a v-on:click="removeElement(index);" style="cursor: pointer">Remove</a></button>
        </table>

        <div>
          <button class="button btn-primary" @click="addRow">Add row</button>
          <hr>
        </div>
      </div>
      <div class="latestRecords">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>exercise</th>
              <th>repetition</th>              
              <th>weight</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="exercise in exerciseRecords" v-bind:key="exercise.id"> 
               <td>{{ exercise.exercise }}</td> 
               <td>{{ exercise.repetitions }}</td>                 
               <td>{{ exercise.weight }}</td>  
            </tr>
           </tbody>
        </table>
      </div>
      <div class="latestSpecificRecords">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>exercise</th>
              <th>repetition</th>              
              <th>weight</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="exercise in exerciseRecords" v-bind:key="exercise.id"> 
               <td>{{ exercise.exercise }}</td> 
               <td>{{ exercise.repetitions }}</td>                 
               <td>{{ exercise.weight }}</td>  
            </tr>
           </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  import Vue from 'vue'

  export default {

      name: 'app',

              data() {
                return{
                  selected:'12',
                  selectedList:[12,1,2,3,4],
                  rows: [],
                  muscleGroups: ['back','bicep'],
                  repetitions: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
                  rowsexc: [],
                  muscleExcercises: [],
                  selectedMuscleGroup: '',
                  selectedMuscleGroupIndex: '',
                  exerciseRecord: {
                    id: '',
                    date: new Date().toISOString().slice(0,10),
                    exercise: '',
                    repetitions: '',
                    weight: ''
                  },
                  exerciseRecords: [],
                }
              },
              created(){
                  this.fetchLatestExerciseRecords();
              },
              methods: {
                  addRow: function() {
                      
                      this.rows.push({

                      });
                     // this.setStandardValueDropdown();
                     this.setStandardValueDropdownClass();
                  },
                  removeElement: function(index) {
                      this.rows.splice(index, 1);
                  },
                  saveRecord: function(){
                    fetch('api/exerciseRecord', {
                        method: 'post',
                        body: JSON.stringify(this.exerciseRecord),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('exerciseRecord Added');
                        //this.fetchWeightRecords();
                    })
                    .catch(err => console.log(err));
                  },
                  setFilename: function(event, row) {
                      var file = event.target.files[0];
                      row.file = file
                  },
                  fetchLatestExerciseRecords: function(page_url){
                    let vm = this;
                    page_url = page_url || '/api/exerciseRecords';
                    fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.exerciseRecords = res.data;
                        console.log(this.exerciseRecords);
                    })
                    .catch( err => console.log(err));
                  },
                  latestSpecificExerciseRecords: function(page_url){
                    let vm = this;
                    page_url = page_url || '/api/latestSpecificExerciseRecords';
                    fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.exerciseRecords = res.data;
                        console.log(this.exerciseRecords);
                    })
                    .catch( err => console.log(err));
                  },
                  fillComboboxBasedOnMuscleGroup: function(){
                    console.log('fillcomboboxmusclegroup');
                    console.log(this);
                    //dropDownSpecificExcercise

                    //var x = document.getElementsByClassName("divexcer");
                    //console.log(x);
                    //x[0].style.display = "block";

                    /*
                    var muscleGroup = document.getElementsByClassName("dropDownSpecificExercise");
                    console.log("muscle group is:" );
                    console.log( muscleGroup);
                    */

                    //this.muscleExcercises = ['biceps curl','hammer curl'];

                    if( this.selectedMuscleGroup == this.muscleGroups[0]){
                      this.muscleExercises = ['back row','pull up'];
                     }else if( this.selectedMuscleGroup == this.muscleGroups[1] ){
                      this.muscleExercises = ['biceps curl','hammer curl'];
                     }else{

                     }
                     console.log( this.muscleExercises );

                    //this.muscleExcercises = this.selectedMuscleGroup == this.muscleGroups[0] ? ['back row','pull up'] : "";
                  },
                  setStandardValueDropdown: function(){

                    var x = document.getElementById("setReps");
                    // x[0].value = 12;
                    console.log("test");
                    console.log(x);
                    x.value = 12;
                    /*
                        setSelectedIndex( document.getElementsByClassName("dropDownSpecificExcerciseRepetitions"),5);
                    */
                  },
                  setStandardValueDropdownClass: function(){
                      var x = document.getElementsByClassName("setReps");
                     // x[0].value = 12;
                      console.log("test");
                      console.log(x.length);

                        x[x.length-1].value = 12;
                      
                      /*
                          setSelectedIndex( document.getElementsByClassName("dropDownSpecificExcerciseRepetitions"),5);
                      */
                  },
                  onChange(event){
                    console.log(event.target.value);
                    
                    this.selectedMuscleGroupIndex = event.target.value;
                    for(let i = 0; i < this.muscleGroups.length; i++){
                      if(this.muscleGroups[i] == this.muscleGroups[this.selectedMuscleGroupIndex]){
                        this.selectedMuscleGroup = this.muscleGroups[i];
                      }
                    }
                    console.log( this.selectedMuscleGroup );
                    this.fillComboboxBasedOnMuscleGroup();
                    
                  }


              }
          };
</script>

