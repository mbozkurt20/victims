import {defineStore} from 'pinia'
import axios from 'axios';
import {ref} from "vue";

export const useAuthStore = defineStore('auth', () => {
    const authenticated = ref(false)
    const user = ref({})
    const token = ref(null)

    const setToken = (t) => {
        token.value = t
        if (t) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + t
        } else {
            delete axios.defaults.headers.common['Authorization']
        }
    }

    const getUser = (() => {
        return axios.get('/api/user').then(({data}) => {
            user.value = data
            authenticated.value = true
        }).catch(() => {
            user.value = {}
            authenticated.value = false
        })
    })

    const logout = (() => {
        user.value = {}
        authenticated.value = false
        setToken(null)
    })

    return {authenticated, user, token, setToken, getUser, logout}
}, {
    persist: true
})
