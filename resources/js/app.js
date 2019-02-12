/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import VueRouter from 'vue-router';
import axios from 'axios';
import Home from './components/Home.vue';
import {routes} from './routes';
import Vue from 'vue';
import VueEvents from 'vue-events';
import wysiwyg from "vue-wysiwyg";

//require('./bootstrap');

Vue.use(VueRouter);
Vue.use(VueEvents);
Vue.use(wysiwyg, {});

const router = new VueRouter({
    mode: 'history',
    routes
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('parent-component', require('./components/ParentComponent.vue').default)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data: {
        message: 'Hi Bro',
        axios: null,
        data: "",
        errors: [],
        status: 0,
        response: null,
        message: "",
        stats : {
            recordCount : "",
            hymnCount : "",
            verseCount : "",
            disabledRecordCount : "",
            performance : "",
        },
    },
    mounted(){
        this.axios = axios.create({
            headers: {'api_token': authToken}
        })
        this.getStats();
        this.$events.listen('reloadStats', eventData => this.getStats());
    },
    methods: {
        addRecord: function () {
            this.errors = [];
            this.status = 0;
            if (!this.data) {
                this.errors.push('The data is empty');
                return;
            }
            this.status = 1;
            let data = {'data': this.data};
            this.axios.post('/api/add-record', data).then((response) => {
                if (response.status == 200) {
                    this.status = 2;
                    this.message = "Record Successfully added";
                    $('#myModal').modal('hide');
                    this.$events.fire('newRecord');
                }else{
                    this.status = 3;
                    this.errors.push("Error in processing records");
                }
            }).catch((error) => {
                this.status = 3;
               this.errors.push("Error in processing records");
            });
        },
        getStats : function(){
            this.axios.get('/api/dashboard/stats').then((response) => {
               let data = response.data;
               if(data.status == 1){
                   this.stats.recordCount = data.data.recordCount;
                   this.stats.hymnCount = data.data.hymnCount;
                   this.stats.verseCount = data.data.verseCount;
                   this.stats.performance = data.data.todayHymnCount;
                   this.stats.disabledRecordCount = data.data.disabledRecordCount;

               }
            })
        }
    }
});
