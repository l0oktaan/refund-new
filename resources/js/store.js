import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersistence from 'vuex-persist'


// Make vue aware of Vuex
Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        user: null,
        userToken: null,
        refund_show: null,
    },
    // plugins: [
    //     createPersistedState({
    //         storage: {
    //             getItem: key => Cookies.get(key),
    //             setItem: (key, value) =>
    //                 Cookies.set(key, value, { expires: 3, secure: true }),
    //             removeItem: key => Cookies.remove(key)
    //         }
    //     })
    // ],
    plugins: [new VuexPersistence().plugin],
    getters: {
        refund_show: state => {
            return state.refund_show;
        },
        user_type (state){
            if (state.user){
                return state.user.type
            }
        },
        user (state){
            if (state.user){
                return state.user
            }
        }
    },
    mutations: {
        authUser (state, userData){
            console.log(userData.user);
            state.user = userData.user
            state.userToken = userData.token
        },
        clearAuthData (state){
            state.user = null
            state.token = null
        },
        SET_USER:(state, value) => {
            state.user = value
        },
        SET_REFUND_SHOW: (state, value) => {
            state.refund_show = value
        },
        FETCH_FORM: (state) => {

        },

    },
    actions: {
        login ({ commit, state}, authData){
            let path = '/api/login'
            axios.post(path,{
                username: authData.username,
                password: authData.password
            })
            .then(response=>{
                commit('authUser',{
                    user: response.data.data,
                    token: response.data.success
                })
            })
        },
        logout({ commit }){
            commit('clearAuthData')
            router.replace('/login')
        },

    }

})
