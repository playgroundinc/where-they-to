import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    status: '',
    user: 0,
    token: localStorage.getItem('token') || '',
    events: [],
    performers: [],
    venues: [],
    families: [],
  },
  actions: {
    login({commit}, data) {
      return new Promise((resolve, reject) => {
        commit('auth_request')
        const { user } = data;
        axios({url: 'http://127.0.0.1:8000/api/auth/login', data: user, method: 'POST' })
        .then(resp => {
          const token = resp.data.token
          const user = resp.data.user
          localStorage.setItem('token', token)
          axios.defaults.headers.common['Authorization'] = token
          commit('auth_success', token, user)
          resolve(resp)
        })
        .catch(err => {
          commit('auth_error')
          localStorage.removeItem('token')
          reject(err)
        })
      })
    },
    fetchState({commit}, data) {
      return new Promise((resolve, reject) => {
        const { route } = data;
        axios.get(`http://127.0.0.1:8000/api/${route}`)
        .then((resp) => {
          commit('set_state', {
            name: route,
            value: resp.data,
          })
          resolve(resp);
          return resp.data;
        }).catch((error) => {
          reject(error);
        })
      })
    },
    fetchSingle({commit}, data) {
      return new Promise((resolve, reject) => {
        const { route } = data;
        const { id } = data;
        axios.get(`http://127.0.0.1:8000/api/${route}/${id}`)
        .then((resp) => {
          resolve(resp);
          return resp.data;
        }).catch((err) => {
          reject(err);
        })
      })
    },
    findUser({commit}) {
      const user = localStorage.getItem('token');
      if (user) {
        return axios({
          url: 'http://127.0.0.1:8000/api/user', 
          headers: {
            'Authorization': `Bearer ${user}`
          },
          method: 'GET' 
        }).then(res => {
          commit('set_state', {
            name: 'user',
            value: res.data.user.id,
          })
          return res.data.user
        }).catch((error)=> {
          commit('set_state', {
            name: 'user',
            value: '0'
          });
          return new Error(error);
        })
      }
    }
  },
  mutations: {
    auth_request(state){
      state.status = 'loading'
    },
    auth_success(state, token, user){
      state.status = 'success'
      state.token = token
      state.user = user
    },
    auth_error(state){
      state.status = 'error'
    },
    logout(state){
      state.status = ''
      state.token = ''
    },
    set_state(state, payload) {
      state[payload.name] = payload.value;
    }
  },
  getters: {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    singlePerformer: (state) => (id) => {
      return state.performers.filter(performer => Number(performer.id) === Number(id));
    }
  }
})