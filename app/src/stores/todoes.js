import {defineStore} from "pinia";

import axios from "axios"

export const useTodoesStore = defineStore("todo",{
    state: () => ({
        todoes: [],
    }),
    getters: {
        getTodoes(state){
            return state.todoes
        }
    },
    actions: {
        async fetchTodoes() {
            try{
                const data = await axios.get('api/todoes')
                this.todoes = data.data.data
                console.log(data)
            } catch(error) {
                alert(error)
                console.log(error)
            }
        }
    },
})