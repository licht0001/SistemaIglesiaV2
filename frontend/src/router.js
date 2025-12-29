import { createRouter, createWebHistory } from 'vue-router';
import MainLayout from './layouts/MainLayout.vue';

const routes = [
    {
        path: '/',
        name: 'landing',
        component: () => import('./views/Landing.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('./views/Login.vue'),
        meta: { requiresGuest: true },
    },
    {
        path: '/',
        component: MainLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: 'dashboard',
                name: 'dashboard',
                component: () => import('./views/Dashboard.vue'),
            },
            {
                path: 'members',
                name: 'members',
                component: () => import('./views/Members.vue'),
            },
            {
                path: 'finances',
                name: 'finances',
                component: () => import('./views/Finances.vue'),
            },
            {
                path: 'activities',
                name: 'activities',
                component: () => import('./views/Activities.vue'),
            },
            {
                path: 'service-areas',
                name: 'service-areas',
                component: () => import('./views/ServiceAreas.vue'),
            },
            {
                path: 'users',
                name: 'users',
                component: () => import('./views/Users.vue'),
            },
            {
                path: 'settings',
                name: 'settings',
                component: () => import('./views/Settings.vue'),
            },
            {
                path: 'landing-settings',
                name: 'landing-settings',
                component: () => import('./views/LandingSettings.vue'),
            },
            {
                path: 'prayer-requests',
                name: 'prayer-requests',
                component: () => import('./views/PrayerRequests.vue'),
            },
        ],
    },
    // Catch all redirect to landing or dashboard?
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    },
});

// Guard de navegación para proteger rutas
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('auth_token');

    // Check if the route requires auth (including parent routes)
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
