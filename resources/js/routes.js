/**
 * Created by user on 2/1/19.
 */
import Home from './components/Home.vue';
import Example from './components/Example.vue';
import HymnDetails from './components/HymnDetails.vue';
import NewHymn from './components/NewHymn.vue';
export const routes = [
    {path: '/home/', component: Home, name: 'Home'},
    {path: '/home/hymn/:id', component: HymnDetails, name: 'HymnDetails'},
    {path: '/home/new', component: NewHymn, name: 'NewHymn'},
    {path: '/vue/example', component: Example, name: 'Example'},
];
