import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import Users from './pages/Users'
import Dashboard from './pages/user/Dashboard'
import AdminDashboard from './pages/admin/Dashboard'

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

import CreateSocialLinks from './pages/socialLinks/Create';
import EditSocialLinks from './pages/socialLinks/Edit';

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
    path: '/venues/:id',
    name: 'venue',
    component: Venue,
    meta: {
      auth: false,
    }
  },
  {
    path: '/venues/:id/edit',
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
    path: '/performers/:id',
    name: 'performer',
    component: Performer,
    meta: {
      auth: false,
    }
  },
  {
    path: '/performers/:id/edit',
    name: 'edit performer',
    component: EditPerformer,
    meta: {
      auth: false,
    }
  },


  {
    path: '/social-links/create',
    name: 'createSocialLinks',
    component: CreateSocialLinks,
    meta: {
      auth: false,
    }
  },
  {
    path: '/users/:id/social-links/:slid/edit',
    name: 'editSocialLinks',
    component: EditSocialLinks,
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
    path: '/events/:id/edit',
    name: 'editEvent',
    component: EditEvent,
    meta: {
      auth: false,
    }
  },
  {
    path: '/events/:eid/social-links',
    name: 'EventSocials',
    component: CreateSocialLinks,
    meta: {
      auth: false,
    }
  },
  {
    path: '/events/:eid/social-links/:slid',
    name: 'EditEventSocials',
    component: EditSocialLinks,
    meta: {
      auth: false,
    }
  },
  {
    path: '/events/:id',
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
    path: '/families/:id/social-links',
    name: 'familySocialLinks',
    component: CreateSocialLinks,
    meta: {
      auth: false,
    }
  },
  {
    path: '/families/:fid/social-links/:slid/edit',
    name: 'EditFamilySocialLinks',
    component: EditSocialLinks,
    meta: {
      auth: false,
    }
  },
  {
    path: '/families/:id/edit',
    name: 'editFamily',
    component: EditFamily,
    meta: {
      auth: false,
    }
  },
  {
    path: '/families/:id',
    name: 'family',
    component: Family,
    meta: {
      auth: false,
    }
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
  }
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

export default router