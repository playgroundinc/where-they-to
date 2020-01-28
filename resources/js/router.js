import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import Users from './pages/Users'
import Dashboard from './pages/user/Dashboard'
import AdminDashboard from './pages/admin/Dashboard'

import Performers from './pages/performer/Performers'
import Performer from './pages/performer/Performer';
import EditPerformer from './pages/performer/Edit';

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
    meta: {
      auth: false
    }
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
    meta: {
      auth: true
    }
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
  }
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

export default router