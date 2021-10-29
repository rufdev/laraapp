import Dashboard from './components/Dashboard.vue'
import Profile from './components/Profile.vue'
import User from './components/Users.vue'
import Role from './components/Roles.vue'

export const routes = [
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
];

