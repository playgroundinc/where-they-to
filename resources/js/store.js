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
    performerTypes: [],
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
          commit('auth_success', {
            token,
            user
          })
          resolve(resp)
        })
        .catch(err => {
          commit('auth_error')
          localStorage.removeItem('token')
          reject(err)
        })
      })
    },
    register({ commit }, user) {
      return new Promise((resolve, reject) => {
        commit('auth_request')
        axios({ url: 'http://127.0.0.1:8000/api/auth/register', data: user, method: 'POST' })
          .then(resp => {
            const token = resp.data.token
            const user = resp.data.user
            localStorage.setItem('token', token)
            // Add the following line:
            axios.defaults.headers.common['Authorization'] = token
            commit('auth_success', {
              token,
              user
            })
            resolve(resp)
          })
          .catch(err => {
            commit('auth_error', err)
            localStorage.removeItem('token')
            reject(err)
          })
      })
    },
    logout({ commit }) {
      return new Promise((resolve, reject) => {
        commit('logout')
        localStorage.removeItem('token')
        delete axios.defaults.headers.common['Authorization']
        resolve()
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
            value: null,
          });
          return new Error(error);
        })
      }
    },
    createPerformer({commit}, data) {
      return new Promise((resolve, reject) => {
        axios({
          url: 'http://127.0.0.1:8000/api/performers',
          method: "POST",
          data
        }).then((resp) => {
          resolve(resp);
          return resp.data;
        }).catch((err) => {
          reject(err);
        });
      })
    },
    createSocialLinks({commit}, data) {
      return new Promise((resolve, reject) => {
        axios({
          url: 'http://127.0.0.1:8000/api/social-links',
          method: "POST",
          data
        }).then((resp) => {
          console.log(resp);
          resolve(resp);
          return resp.data;
        }).catch((err) => {
          reject(err);
        });
      })
    }

  },
  mutations: {
    auth_request(state){
      state.status = 'loading'
    },
    auth_success(state, payload){
      state.status = 'success'
      state.token = payload.token
      state.user = payload.user.id
    },
    auth_error(state){
      state.status = 'error'
    },
    logout(state){
      state.status = ''
      state.token = ''
      state.user = ''
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