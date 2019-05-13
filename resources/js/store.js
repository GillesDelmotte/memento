import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

const state = {
    currentUser: null,
    currentComponent: null,
    allJob: null,
    allPractitioner: null,
    allSchedule: null,
    schedule: null,
    appointments: null,
};

const getters = {};

const mutations = {
    setComponentDisplayed(state, component) {
        state.currentComponent = component
    },
    setCurrentUser(state, user) {
        state.currentUser = user
    },
    setAllJob(state, jobs) {
        state.allJob = jobs;
    },
    setAllPractitioner(state, practitioners) {
        state.allPractitioner = practitioners;
    },
    setAllSchedule(state, schedules) {
        state.allSchedule = schedules;
    },
    setSchedule(state, schedule) {
        state.schedule = schedule;
    },
    setAppointments(state, appointments) {
        state.appointments = appointments;
    }
};

const actions = {
    setCurrentUser({ commit }) {
        return new Promise((resolve, reject) => {
            window.axios.get('/authenticated-user')
                .then(response => {
                    commit('setCurrentUser', response.data)
                    resolve()
                })
        })
    },
    setAllJob({ commit }) {
        return new Promise((resolve, reject) => {
            window.axios.get('/getJobs')
                .then(response => {
                    commit('setAllJob', response.data)
                    resolve()
                })
        })
    },
    setAllPractitioner({ commit }) {
        return new Promise((resolve, reject) => {
            window.axios.get('/getPractitioners')
                .then(response => {
                    commit('setAllPractitioner', response.data)
                    resolve()
                })
        })
    },
    setAllSchedule({ commit }) {
        return new Promise((resolve, reject) => {
            window.axios.get('/getSchedules')
                .then(response => {
                    commit('setAllSchedule', response.data)
                    resolve()
                })
        })
    },
    setScheduleDays({ commit }, payload) {
        return new Promise((resolve, reject) => {
            window.axios.post('/getSchedule', { id: payload })
                .then(response => {
                    commit('setSchedule', response.data)
                    resolve()
                })
        })
    },
    setAppointments({ commit }, payload) {
        return new Promise((resolve, reject) => {    
            window.axios.post('/setAppointments', payload)
                .then(response => {
                    commit('setAppointments', response.data)
                    resolve()
                })
        })
    }
};

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions
})
