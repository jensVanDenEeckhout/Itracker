
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
      grid-template-columns: auto auto ;
      grid-template-rows: auto auto;

      grid-gap: 30px;
      margin:30px;
      align-items: center;
    }
    .addExerciseRecord{
      grid-column-start: 1;
      grid-column-end: 3;
    }
</style>

<template>
  <div id="app">
    <div class="exerciseRecord">
      <div class="addExerciseRecord">
        <td>
          <select required id="dropDown" @change="onChange($event)">
            <option>Select</option>
            <option v-for="(muscleGroup,index) in muscleGroups"  v-bind:value="index">{{ muscleGroup }} </option>
          </select>
        </td>  


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
                      <select required class="dropDownSpecificExercise" @change="onChangeExcercise($event)" v-model="exerciseRecord.exercise" >
                        <option>Select</option>
                        <option v-for="muscleExercise in muscleExercises">{{ muscleExercise }}</option>
                      </select>
                    </td> 

                    <td>
                      <select required class="setReps"  v-model="exerciseRecord.repetitions" >
                        <option>Select </option>
                        <option v-for="repetition in repetitions" v-bind:value="repetition">{{ repetition }}</option>
                      </select>
                    </td>  

                     <td>
                      <select required class="setWeight" v-model="exerciseRecord.weight">
                        <option>Select </option>
                        <option v-for="repetition in repetitions">{{ repetition }}</option>
                      </select>
                    </td>  

                </tr>
            </tbody>

            <tbody>
              <td>
                <button class="btn-success"><a  v-on:click="saveRecord();" style="cursor: pointer">Save</a></button>
              </td>
              <td>
              <button class="btn-danger"><a v-on:click="removeElement(index);" style="cursor: pointer">Remove</a></button>
                </td>
              </tbody>            
              
        </table>
      </div>

      <div class="latestRecords">
        <h3 style="text-align:center"> Latest records</h3>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>date</th>                   
              <th>exercise</th>
              <th>repetition</th>              
              <th>weight</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="exercise in exerciseRecords" v-bind:key="exercise.id"> 
               <td>{{ exercise.date }}</td>               
               <td>{{ exercise.exercise }}</td> 
               <td>{{ exercise.repetitions }}</td>                 
               <td>{{ exercise.weight }}</td>  
            </tr>
           </tbody>
        </table>
      </div>

      <div class="latestSpecificRecords">
        <h3 style="text-align:center"> Specific records</h3>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>date</th>              
              <th>exercise</th>
              <th>repetition</th>              
              <th>weight</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="exercise in specificExerciseRecords" v-bind:key="exercise.id"> 
               <td>{{ exercise.date }}</td> 
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
                  muscleGroups: ['back','bicep','chest','tricep','legs','shoulder'],

                  back_exercises: ['back row','pull up'],
                  biceps_exercises: ['biceps curl','hammer curl'],
                  chest_exercises: ['halter bench press','chest dips'],
                  triceps_exercises: ['tricep extension','tricep rope pushdown'],
                  leg_exercises: ['seated leg curl','leg extension'],
                  shoulder_exercises: ['shoulder press','dumbbell front raise'],

                  repetitions: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
                  rowsexc: [],
                  muscleExercises: [],
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
                  specificExerciseRecords: [],
                  selectedExercise: '',

                }
              },
              created(){
                  this.fetchLatestExerciseRecords();
                  //this.latestSpecificExerciseRecords();

              },
              methods: {
                  fetchAllRecordFunctions(){
                    this.fetchLatestExerciseRecords();
                    this.latestSpecificExerciseRecords();
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
                        //alert('exerciseRecord Added');
                        //this.fetchWeightRecords();
                    })
                    .catch(err => console.log(err));

                    this.fetchAllRecordFunctions();
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
                        this.specificExerciseRecords = res.data;
                        console.log(this.specificExerciseRecords);
                    })
                    .catch( err => console.log(err));
                  },
                  fillComboboxBasedOnMuscleGroup: function(){
                    console.log('fillcomboboxmusclegroup');
                    console.log(this);
                    //'back','bicep','chest','tricep','legs','shoulder

                    /*
                   back_exercises: ['back row','pull up'],
                  biceps_exercises: ['biceps curl','hammer curl'],
                  chest_exercises: ['halter bench press','chest dips'],
                  triceps_exercises: ['tricep extension','tricep rope pushdown'],
                  leg_exercises: ['seated leg curl','leg extension'],
                  shoulder_exercises: ['shoulder press','dumbbell front raise'],
                  */
                    if( this.selectedMuscleGroup == this.muscleGroups[0]){
                      this.muscleExercises = this.back_exercises;
                    }else if( this.selectedMuscleGroup == this.muscleGroups[1] ){
                      this.muscleExercises = this.biceps_exercises;
                    }else if( this.selectedMuscleGroup == this.muscleGroups[2] ){
                      this.muscleExercises = this.chest_exercises;
                    }else if( this.selectedMuscleGroup == this.muscleGroups[3] ){
                      this.muscleExercises = this.triceps_exercises;
                    }else if( this.selectedMuscleGroup == this.muscleGroups[4] ){
                      this.muscleExercises = this.leg_exercises;
                    }else if( this.selectedMuscleGroup == this.muscleGroups[5] ){
                      this.muscleExercises = this.shoulder_exercises;
                    }else{
                    }
                     console.log( this.muscleExercises );

                  },
                  onChange(event){
                   
                    if( this.rows.length === 0){
                      this.rows.push({
                      });
                    }

                    this.selectedMuscleGroupIndex = event.target.value;
                    for(let i = 0; i < this.muscleGroups.length; i++){
                      if(this.muscleGroups[i] == this.muscleGroups[this.selectedMuscleGroupIndex]){
                        this.selectedMuscleGroup = this.muscleGroups[i];
                      }
                    }
                    console.log( this.selectedMuscleGroup );
                    this.fillComboboxBasedOnMuscleGroup();
                    
                  },
                  onChangeExcercise(event){
                    this.selectedExercise = event.target.value;
                    console.log( this.selectedExercise );
                    fetch('api/showSpecificExercise', {
                        method: 'post',
                        body: JSON.stringify(this.selectedExercise),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                      this.specificExerciseRecords = res.data;
                        //alert('exercise changes');
                        //this.fetchWeightRecords();
                    })
                    .catch(err => console.log(err));

                    //this.fetchAllRecordFunctions();
                  }
              }
          };
</script>

