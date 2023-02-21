import Dashboard from './components/Dashboard.vue'
import Profile from './components/Profile.vue'
import User from './components/Users.vue'
import Role from './components/Roles.vue'
import ExampleComponent from './components/ExampleComponent.vue'
import SchoolPage from './components/transaction/SchoolPage.vue'

export const routes = [
    {
        path:'/',
        component:Dashboard
    },
    {
        path:'/dashboard',
        component:Dashboard
    },
    {
        path:'/profile',
        component:Profile
    },
    { 
        path:'/users',
        component:User
    },
    { 
        path:'/roles',
        component:Role
    },
    { path: '/developer', component: require('./components/Developer.vue').default },
    {
        path:'/sample',
        component:ExampleComponent
    },
    {
        path:'/school',
        component:SchoolPage
    },

];

