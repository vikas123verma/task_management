import { createRouter, createWebHistory } from "vue-router";
import Login from '../components/Login.vue'
import Home from "../components/Home.vue";
import authGuard from "../auth";
import TaskList from "../components/TaskList.vue";
import TaskEdit from "../components/TaskEdit.vue"
import TaskAdd from "../components/TaskAdd.vue";
import Register from "../components/Register.vue";

const routes = [
    {
        path:'/',
        name:'Home',
        component: Home
    },
    {
        path:'/login',
        name:'Login',
        component: Login
    },
    {
        path:'/register',
        name:'Register',
        component: Register
    },
    {
        path:'/tasks',
        name:'Tasks',
        component: TaskList,
        beforeEnter: authGuard
    },
    {
        path:'/tasks/:uuid',
        component: TaskEdit,
        beforeEnter: authGuard
    },
    {
        path:'/task/add',
        component: TaskAdd,
        beforeEnter: authGuard
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;
