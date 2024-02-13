import Vue from 'vue';
import VueRouter from 'vue-router';
import AdminDashboard from './components/AdminPage.vue';
import ManagerDashboard from './components/ManagerPage.vue';
import EmployeeDashboard from './components/EmployeePage.vue';
import Login from './components/Auth/Login.vue';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        redirect: '/login',
    },
    {
        path: '/login',
        component: Login,
    },
    {
        path: '/admin-dashboard',
        component: AdminDashboard,
        meta: { requiresAuth: true, role: 'admin' },
    },
    {
        path: '/manager-dashboard',
        component: ManagerDashboard,
        meta: { requiresAuth: true, role: 'manager' },
    },
    {
        path: '/employee-dashboard',
        component: EmployeeDashboard,
        meta: { requiresAuth: true, role: 'employee' },
    },
];

const router = new VueRouter({
    routes,
    mode: 'history',
});

export default router;