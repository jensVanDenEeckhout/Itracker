<template id="dropdown">
  <div class="my-dropdown">
    <!-- On click we call the toggle method -->
  <div class="selected" @click="toggle">Selected value</div>
    <div class="options" v-show="isOpen">
     <!-- v-for loops trough `options` -->
    <!-- and renders a div containing the `option`s value. -->
    <div class="option" 
        v-for="option in taskItems"
        @click="set(option)">
      {{ option.name }}
    </div>
    </div>
    <div>{{selected}}</div>
  </div>
</template>


<style lang="scss" scoped>
  /* Some boilerplating */
* { box-sizing: border-box; }
body { font-size: 62.5%; background: #00aca0; }

/* My dropdown */
.my-dropdown {
  cursor: pointer;
  //transform: translate(-50%, -70px);
  min-width: 350px;
  height: 40px;
}

/* Selected */
.selected {
  position: relative;
  z-index: 2;
  display: block;
  width: 100%;
  height: 40px;
  padding: 0 20px;
  background: #054641;
  border-radius: 10px;
  font: 1.25rem/40px 'Ubuntu', Helvetica, Arial, sans-serif;
  text-shadow: 2px 2px 0px #000;
  color: #fff;  
}

/* Arrow */
.selected:after {
  opacity: 0.5;
  display: inline-block;
  margin-left: 10px;
  content: '▼';
}

/* Hover state */
.selected:hover:after {
  opacity: 1;
}

/* Options wrapper (toggled by isOpen) */
.options {
  //position: absolute;
  left: 0;
  top: 100%;
  z-index: 1;
  width: 100%;
  margin-top: 3px;
  background: #fff;
  border-radius: 10px;
}

/* Option */
.option {
  padding: 5px 20px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25);
  font: 1.2rem 'Vollkorn', Georgia, Times, serif;
}

/* Hover state */
.option:hover {
  background-color: rgba(0, 0, 0, 0.05);
}

/* Reset last child for a nice layout */
.option:last-child {
  border-bottom: none;
}

/* Transition */
.fade-enter-active, .fade-leave-active {
  transition: all .25s ease-out;
}

.fade-enter, .fade-leave-active {
  opacity: 0;
	transform: translateY(-30px);
}
</style>


<script>
import Vue from 'vue'
import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'

Vue.use(Chartkick.use(Chart))

export default {
    name: 'app',
    data: function() {
    return {
        // Whether the options are visible or not.
        isOpen: true,
        // The selected value.
        selected: 'Select your favourite beer',
        // Options.
        tasks: []
    }
    },
    computed: {
        taskItems(){
            return this.tasks;
        }
    },
    created(){
        this.fetchTasks();
    },
    
    methods: {
        toggle: function() {
        this.isOpen = !this.isOpen;
        if(this.isOpen){
            this.fetchTasks();
        }
        },
        show: function() {
        
        this.isOpen = true;
        },
        hide: function() {
        this.isOpen = false;
        },
        // Set option as    selected state and close dropdown.
    set: function(option) {
        this.selected = option;
        this.hide();
    },
    fetchTasks(page_url){
            let vm = this;
            page_url = page_url || '/api/tasks';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.tasks = res.data;
            })
            .catch( err => console.log(err));
        },   
    },
    // This function is called when the DOM is ready.
    mounted: function() {
        console.log('My dropdown component is mounted!')
    }
};
</script>