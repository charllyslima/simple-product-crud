// src/stores/user.ts
import { defineStore } from 'pinia'

interface UserState {
    name: string | null
    token: string | null
}
const localStorageUserKey = 'spc_user'
export const useUserStore = defineStore({
    id: 'user',
    state: (): UserState => {
        const savedUser = localStorage.getItem(localStorageUserKey)
        if (savedUser) {
            return JSON.parse(savedUser)
        }
        return {
            name: null,
            token: null
        }
    },
    actions: {
        setUser(name: string, token: string) {
            this.name = name
            this.token = token
            localStorage.setItem(localStorageUserKey, JSON.stringify(this.$state))
        },
        clearUser() {
            this.name = null
            this.token = null
            localStorage.removeItem(localStorageUserKey)
        }
    },
    getters: {
        isAuthenticated: (state) => !!state.token
    }
})
