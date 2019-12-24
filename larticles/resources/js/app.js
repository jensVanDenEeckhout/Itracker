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

import wtg3 from './components/WeightTrackerAddGraphDataShow';
import se from './components/StrengthExcercise';
 

const app = new Vue({
  el: '#app',
  components:{
    articles:articles,
    navbar:navbar,
    weighttracker:weighttracker,
    ct1:ct1, 
    wtg:wtg,
    wtg3:wtg3,
    se:se
  }
});