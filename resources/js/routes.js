/**
 * Created by user on 2/1/19.
 */
import Home from './components/Home.vue';
import Example from './components/Example.vue';
import HymnDetails from './components/HymnDetails.vue';
export const routes = [
    {path: '/home/', component: Home, name: 'Home'},
    {path: '/home/hymn/:id', component: HymnDetails, name: 'HymnDetails'},
    {path: '/vue/example', component: Example, name: 'Example'},
];
