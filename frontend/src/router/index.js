import { createRouter, createWebHistory } from 'vue-router';
import Landing from '../views/Landing.vue';
import Login from '../views/Login.vue';
import MainLayout from '../layouts/MainLayout.vue';
import Dashboard from '../views/Dashboard.vue';
import Members from '../views/Members.vue';
import Finances from '../views/Finances.vue';
import Activities from '../views/Activities.vue';
import ServiceAreas from '../views/ServiceAreas.vue';
import Users from '../views/Users.vue';
import Settings from '../views/Settings.vue';
import LandingSettings from '../views/LandingSettings.vue';
import PrayerRequests from '../views/PrayerRequests.vue';

const routes = [
    {
        path: '/',
        name: 'landing',
        component: Landing,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { requiresGuest: true },
    },
    {
        path: '/',
        component: MainLayout,
        meta: { requiresAuth: true },
        children: [
            { path: 'dashboard', name: 'dashboard', component: Dashboard },
            { path: 'members', name: 'members', component: Members },
            { path: 'finances', name: 'finances', component: Finances },
            { path: 'activities', name: 'activities', component: Activities },
            { path: 'service-areas', name: 'service-areas', component: ServiceAreas },
            { path: 'users', name: 'users', component: Users },
            { path: 'settings', name: 'settings', component: Settings },
            { path: 'landing-settings', name: 'landing-settings', component: LandingSettings },
            { path: 'prayer-requests', name: 'prayer-requests', component: PrayerRequests },
        ],
    },
    { path: '/:pathMatch(.*)*', redirect: '/' }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('auth_token');
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const requiresGuest = to.matched.some(record => record.meta.requiresGuest);
    if (requiresAuth && !isAuthenticated) {
        next('/login');
    } else if (requiresGuest && isAuthenticated) {
        next('/dashboard');
    } else {
        next();
    }
});

export default router;
