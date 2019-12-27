
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
</style>

<template>
  <div id="app">

              <td>
                <select required id="dropDown" @change="onChange($event)">
                  <option>Select here</option>
                  <option v-for="(muscleGroup,index) in muscleGroups"  v-bind:value="index">{{ muscleGroup }} </option>
                </select>
              </td>  


              <div class="divexcer">  
                <td>
                  <select required class="dropDownSpecificExcercise" >
                    <option>Select here</option>
                    <option v-for="(muscleExcercise,index) in muscleExcercises">{{ muscleExcercise }}</option>
                  </select>
                </td>  
              </div>  

                 <td>
                  <select required class="setReps1" >
                    <option>Select here</option>
                    <option v-for="repetition in repetitions" v-bind:value="repetition">{{ repetition }}</option>
                  </select>
                </td>  
           


      <table class="table">
          <thead>
              <tr>

                  <td><strong>Dropdown </strong></td>

                  <td><strong>set1 repetitions</strong></td>
                  <td><strong>set1 weight</strong></td>


    <!--
                  <td><strong>set2 repetitions</strong></td>
                  <td><strong>set2 weight</strong></td>

                  <td><strong>set3 repetitions</strong></td>
                  <td><strong>set3 weight</strong></td>

                  <td><strong>File</strong></td>

                -->
                  <td></td>
              </tr>
          </thead>
          <tbody>



              <tr v-for="(row, index) in rows">

<!--
                  <td>
                    <select required class="dropDownSpecificExcercise" >
                      <option>Select here</option>
                      <option v-for="muscleExcercise in muscleExcercises">{{ muscleExcercise }}</option>
                    </select>
                  </td> 

                  <td>
                    <select required class="setReps" v-model="selectedList[index]" >
                      <option>Select here</option>
                      <option v-for="repetition in repetitions" v-bind:value="repetition">{{ repetition }}</option>
                    </select>
                  </td>  


                   <td>
                    <select required class="setWeight"  >
                      <option>Select here</option>
                      <option v-for="repetition in repetitions">{{ repetition }}</option>
                    </select>
                  </td>  
-->

<!--
                  <td><input type="text" v-model="row.title"></td>
                  <td><input type="text" v-model="row.description"></td>


                  <td><input type="text" v-model="row.title"></td>
                  <td><input type="text" v-model="row.description"></td>

                  <td><input type="text" v-model="row.title"></td>
                  <td><input type="text" v-model="row.description"></td>
        -->

        <form @submit.prevent="saveRecord" class="mb-3"> 


                  <td>
                    <select required class="dropDownSpecificExcercise" v-model="excerciseRecord.exercise" >
                      <option>Select here</option>
                      <option v-for="muscleExcercise in muscleExcercises">{{ muscleExcercise }}</option>
                    </select>
                  </td> 

                  <td>
                    <select required class="setReps"  v-model="excerciseRecord.repetitions" >
                      <option>Select here</option>
                      <option v-for="repetition in repetitions" v-bind:value="repetition">{{ repetition }}</option>
                    </select>
                  </td>  


                   <td>
                    <select required class="setWeight" v-model="excerciseRecord.weight" >
                      <option>Select here</option>
                      <option v-for="repetition in repetitions">{{ repetition }}</option>
                    </select>
                  </td>  







<!--
            <button type="submit" class="btn btn-success"><a style="cursor: pointer">Save</a></button> 
        </form>
-->


<!--


                  <td>
                    <button class="btn-success"><a  v-on:click="saveRecord();" style="cursor: pointer">Save</a></button>

                   <button class="btn-danger"><a v-on:click="removeElement(index);" style="cursor: pointer">Remove</a></button>


                  </td>
-->
              </tr>
          </tbody>
      </table>
      <div>
          <button class="button btn-primary" @click="addRow">Add row</button>
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
                  excerciseRecord: {
                    id: '',
                    date: new Date().toISOString().slice(0,10),
                    exercise: '',
                    repetitions: '',
                    weight: ''
                  }
                }
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
                    fetch('api/excerciseRecord', {
                        method: 'post',
                        body: JSON.stringify(this.excerciseRecord),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('excerciseRecord Added');
                        //this.fetchWeightRecords();
                    })
                    .catch(err => console.log(err));
                  },
                  setFilename: function(event, row) {
                      var file = event.target.files[0];
                      row.file = file
                  },
                  fillComboboxBasedOnMuscleGroup: function(){
                    console.log(this);
                    //dropDownSpecificExcercise

                    var x = document.getElementsByClassName("divexcer");
                    console.log(x);
                    x[0].style.display = "block";

                    var muscleGroup = document.getElementsByClassName("dropDownSpecificExcercise");
                    console.log(muscleGroup.text);
                    //this.muscleExcercises = ['biceps curl','hammer curl'];

                    if( this.selectedMuscleGroup == this.muscleGroups[0]){
                      this.muscleExcercises = ['back row','pull up'];
                     }else if( this.selectedMuscleGroup == this.muscleGroups[1] ){
                      this.muscleExcercises = ['biceps curl','hammer curl'];
                     }else{

                     }

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
                    //console.log( this.selectedMuscleGroup );
                    this.fillComboboxBasedOnMuscleGroup();
                    
                  }


              }
          };
</script>

