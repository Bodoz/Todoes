import {defineStore} from "pinia";

import axios from "axios"
import {tr} from "vuetify/locale";

let loadingLists = false

export const useTodoesStore = defineStore("todo",{
    state: () => ({
        todoes: [],
        lists: null,
    }),
    //getters: {
    //    getTodoes(state){
    //        return state.todoes
    //    }
    //},
    actions: {
        async fetchTodoes() {
            try{
                const data = await axios.get('api/todoes')
                let todoes = data.data.data
                //for (let i in todoes) todoes[i].done = !!todoes[i].done
                this.todoes = todoes
                console.log(data)
            } catch(error) {
                alert(error)
                console.log(error)
            }
        },
        async updateTodo(todo) {
            const ix = this.todoes.findIndex(x => x.id === todo.id)
            const t = this.todoes[ix]
            t.isLoading = true
            const data = await axios.put(`api/todoes/${todo.id}`, todo)
            this.todoes[ix] = data.data.data[0]
            t.isLoading = false
        },
        async deleteTodo(id){
            const t = this.todoes.find(x => x.id === id)
            t.isLoading = true
            const data = await axios.delete(`api/todoes/${id}`)
            console.log(data.data)
            if (data.data.result) {
                //this.todoes.splice(this.todoes.indexOf(x => x.id === todo.id), 1)
                this.todoes = this.todoes.filter(x => x.id !== id)
            }
            t.isLoading = false
        },
        async newTodo(todo) {
            const data = await axios.post(`api/todoes/`, todo)
            if(data.data.result){
                this.todoes.push(data.data.data[0])
            }
        },
        async fetchLists() {
            if(this.lists === null && loadingLists === false) {
                loadingLists = true
                try {
                    const response = await axios.get('api/lists')
                    this.lists = response.data.data
                    //console.log(response)
                } catch (error) {
                    alert(error)
                    console.log(error)
                }
                loadingLists = false
            }
        },
    },
})