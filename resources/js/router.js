import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import Users from './pages/Users'
import Dashboard from './pages/user/Dashboard'
import AdminDashboard from './pages/admin/Dashboard'
import Search from './pages/Search';

import Events from './pages/events/Events';
import Event from './pages/events/Event';
import EditEvent from './pages/events/Edit';
import CreateEvent from './pages/events/Create';

import Family from './pages/family/Family';
import EditFamily from './pages/family/Edit';
import CreateFamily from './pages/family/Create';

import Performers from './pages/performer/Performers'
import Performer from './pages/performer/Performer';
import EditPerformer from './pages/performer/Edit';
import CreatePerformer from './pages/performer/Create';

import Venues from './pages/venues/Venues';
import Venue from './pages/venues/Venue';
import EditVenue from './pages/venues/Edit';
import CreateVenue from './pages/venues/Create';


// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    // USER ROUTES
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
    },
    // ADMIN ROUTES
    {
        path: '/admin',
        name: 'admin.dashboard',
        component: AdminDashboard,
        meta: {
            auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
        }
    },
    // USER ROUTES
    {
        path: '/users',
        name: 'users',
        component: Users,
        meta: {
            auth: false,
        }
    },
    // VENUES ROUTES
    {
        path: '/venues',
        name: 'venues',
        component: Venues,
        meta: {
            auth: false,
        }
    },

    {
        path: '/venues/create',
        name: 'createVenue',
        component: CreateVenue,
        meta: {
            auth: false,
        }
    },
    {
        path: '/venues/:slug',
        name: 'venue',
        component: Venue,
        meta: {
            auth: false,
        }
    },
    {
        path: '/venues/:slug/edit',
        name: 'editVenue',
        component: EditVenue,
        meta: {
            auth: false,
        }
    },

    // PERFORMER ROUTES
    {
        path: '/performers',
        name: 'performers',
        component: Performers,
        meta: {
            auth: false,
        }
    },

    {
        path: '/performers/create',
        name: 'createPerformer',
        component: CreatePerformer,
        meta: {
            auth: false,
        }
    },
    
    {
        path: '/performers/:slug',
        name: 'performer',
        component: Performer,
        meta: {
            auth: false,
        }
    },
    {
        path: '/performers/:slug/edit',
        name: 'edit performer',
        component: EditPerformer,
        meta: {
            auth: false,
        }
    },

    // EVENTS ROUTES

    {
        path: '/events',
        name: 'events',
        component: Events,
        meta: {
            auth: false,
        }
    },
    {
        path: '/events/create',
        name: 'createEvents',
        component: CreateEvent,
        meta: {
            auth: false,
        }
    },
    {
        path: '/events/:slug/edit',
        name: 'editEvent',
        component: EditEvent,
        meta: {
            auth: false,
        }
    },
    {
        path: '/events/:slug',
        name: 'Event',
        component: Event,
        meta: {
            auth: false,
        }
    },
    // FAMILIES ROUTES
    {
        path: '/families/create',
        name: 'createFamily',
        component: CreateFamily,
        meta: {
            auth: false,
        }
    },
    {
        path: '/families/:slug/edit',
        name: 'editFamily',
        component: EditFamily,
        meta: {
            auth: false,
        }
    },
    {
        path: '/families/:slug',
        name: 'family',
        component: Family,
        meta: {
            auth: false,
        }
    },
    {
        path: '/search',
        name: 'search',
        component: Search,
        meta: {
            auth: false,
        }
    },
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})

export default router