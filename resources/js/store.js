import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    status: '',
    user: {},
    token: localStorage.getItem('token') || '',
    events: [],
    performers: [],
    venues: [],
    families: []
  },
  actions: {
    login({commit}, user) {
      commit('auth_success', token, user);
    },
    setState({commit}, name, value) {
      commit('set_state', name, value)
    }
  },
  mutations: {
    auth_success(state, token, user) {
      state.user = user
      state.token = token
      state.status = 'Logged In'
    },
    set_state(state, name, array) {
      state[name] = array;
    }
  },
  getters: {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status
  }
})