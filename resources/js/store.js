import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        status: "",
        user: 0,
        token: localStorage.getItem("token") || "",
    },
    actions: {
        login({ commit }, data) {
            return new Promise((resolve, reject) => {
                commit("auth_request");
                axios({
                    url: "http://127.0.0.1:8000/api/auth/login",
                    data,
                    method: "POST"
                })
                    .then(resp => {
                        const token = resp.data.token;
                        const user = resp.data.user;
                        localStorage.setItem("token", token);
                        axios.defaults.headers.common["Authorization"] = token;
                        commit("auth_success", {
                            token,
                            user
                        });
                        resolve(resp);
                    })
                    .catch(err => {
                        commit("auth_error");
                        localStorage.removeItem("token");
                        reject(err);
                    });
            });
        },
        register({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit("auth_request");
                axios({
                    url: "http://127.0.0.1:8000/api/auth/register",
                    data: user,
                    method: "POST"
                })
                    .then(resp => {
                        const token = resp.data.token;
                        const user = resp.data.user;
                        localStorage.setItem("token", token);
                        // Add the following line:
                        axios.defaults.headers.common["Authorization"] = token;
                        commit("auth_success", {
                            token,
                            user
                        });
                        resolve(resp);
                    })
                    .catch(err => {
                        commit("auth_error", err);
                        localStorage.removeItem("token");
                        reject(err);
                    });
            });
        },
        logout({ commit }) {
            return new Promise((resolve, reject) => {
                commit("logout");
                localStorage.removeItem("token");
                delete axios.defaults.headers.common["Authorization"];
                resolve();
            });
        },
        fetchState({ commit }, data) {
            return new Promise((resolve, reject) => {
                const { route } = data;
                axios
                    .get(`http://127.0.0.1:8000/api/${route}`)
                    .then(resp => {
                        resolve(resp);
                        return resp.data;
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        fetchSingle({ commit }, data) {
            return new Promise((resolve, reject) => {
                const { route } = data;
                const { id } = data;
                axios
                    .get(`http://127.0.0.1:8000/api/${route}/${id}`)
                    .then(resp => {
                        resolve(resp);
                        return resp.data;
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        fetchDate({ commit }, data) {
            return new Promise((resolve, reject) => {
                const { date } = data;
                const { parameter } = data;
                axios
                    .get(
                        `http://127.0.0.1:8000/api/events/${parameter}/${date}`
                    )
                    .then(resp => {
                        resolve(resp);
                        return resp;
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        findUser({ commit }) {
            const user = localStorage.getItem("token");
            return new Promise((resolve, reject) => {
                if (user) {
                    axios({
                        url: "http://127.0.0.1:8000/api/user",
                        headers: {
                            Authorization: `Bearer ${user}`
                        },
                        method: "GET"
                    })
                        .then(res => {
                            if (res.data.user) {
                            commit("set_state", {
                                name: "user",
                                value: {
                                    id: res.data.user.id,
                                    city: res.data.user.city,
                                    province: res.data.user.province,
                                    country: res.data.user.country,
                                    timezone: res.data.user.timezone,
                                    events: res.data.user.events || [],
                                    venues: res.data.user.venues || [],
                                    performers: res.data.user.performers || [],
                                    families: res.data.user.families || []
                                }
                            });
                            resolve(res);
                            return res.data.user;
                        }
                        commit("set_state", {
                            name: "user",
                            value: false
                        });
                    })
                    .catch(error => {
                        commit("set_state", {
                            name: "user",
                            value: null
                        });
                        reject(error);
                        return;
                    });
                }
            });
        },
        create({ commit, state }, payload) {
            return new Promise((resolve, reject) => {
                const user = localStorage.getItem("token");
                axios({
                    url: `http://127.0.0.1:8000/api/${payload.route}`,
                    headers: {
                        Authorization: `Bearer ${state.token}`
                    },
                    method: "POST",
                    data: payload.data
                })
                    .then(resp => {
                        resolve(resp);
                        return resp.data;
                    })
                    .catch(err => {
                        reject(err);
                    });
            });
        },
        edit({ commit, state }, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `http://127.0.0.1:8000/api/${payload.route}/${payload.id}`,
                    headers: {
                        Authorization: `Bearer ${state.token}`
                    },
                    method: "PUT",
                    data: payload.data
                })
                    .then(resp => {
                        this.dispatch("fetchState", { route: payload.route });
                        resolve(resp);
                        return resp.data;
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        destroy({ state }, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    url: `http://127.0.0.1:8000/api/${payload.route}/${payload.id}`,
                    headers: {
                        Authorization: `Bearer ${state.token}`
                    },
                    method: "DELETE",
                    data: payload.data
                })
                    .then(resp => {
                        this.dispatch("fetchState", {
                            route: payload.route
                        });
                        resolve(resp);
                        return resp.data;
                    })
                    .catch(error => {
                        reject(error);
                        return error.message;
                    });
            });
        }
    },
    mutations: {
        auth_request(state) {
            state.status = "loading";
        },
        auth_success(state, payload) {
            state.status = "success";
            state.token = payload.token;
            state.user = {
                id: payload.user.id,
                type: payload.user.type,
                socialLinks: payload.user.socialLinks,
                events: payload.user.events,
                families: payload.user.families,
                venues: payload.user.venues,
                performers: payload.user.performers,
            };
        },
        auth_error(state) {
            state.status = "error";
        },
        logout(state) {
            state.status = "";
            state.token = "";
            state.user = "";
        },
        set_state(state, payload) {
            state[payload.name] = payload.value;
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status
    }
});
