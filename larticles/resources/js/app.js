/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('articles', require('./components/Articles.vue'));

import articles from './components/Articles';
import navbar from './components/Navbar';
//import sleeptracker from './components/SleepTracker';
import weighttracker from './components/WeightTracker';

import ct1 from './components/ChartTest1';
import wtg from './components/WeightTrackerGraph';

import weight_tracker_with_graph from './components/WeightTrackerAddGraphDataShow';
import add_stength_exercise_record from './components/StrengthExcercise';
 
import wtgtest from './components/Test';

import introduction from './components/Introduction';

import add_task from './components/AddTask';

import dropdown from './components/Dropdown'

import day_record from './components/DayRecord'

const app = new Vue({
  el: '#app',
  components:{
    articles:articles,
    navbar:navbar,
    weighttracker:weighttracker,
    ct1:ct1, 
    wtg:wtg,
    weight_tracker_with_graph:weight_tracker_with_graph,
    add_stength_exercise_record:add_stength_exercise_record,
    wtgtest:wtgtest,
    introduction:introduction,
    add_task:add_task,
    dropdown:dropdown,
    day_record:day_record
  }
});