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
                let todoes = data.data.data
                for (let i in todoes) todoes[i].done = !!todoes[i].done
                this.todoes = todoes
                console.log(data)
            } catch(error) {
                alert(error)
                console.log(error)
            }
        },
        async updateTodo(id) {
            //console.log('TodoStore.action.updateTodo:',todo)
            //console.log('TodoStore.actions.updateTodo:',id)
            const t = this.todoes.find(x => x.id === id)
            t.isLoading = true
            //console.log(t)
            const data = await axios.put(`api/todoes/${id}`, t)
            let todo = data.data.data[0] //FIXME: gestire errore se vuoto
            console.log(todo)
            this.todoes[this.todoes.indexOf(x => x.id === todo.id)] = todo
            t.isLoading = false
        },
        async confirmDeleteTodo(id){
            const t = this.todoes.find(x => x.id === id)
            t.isLoading = true
            const data = await axios.delete(`api/todoes/${id}`)
            if (data.data.data.result) {
                this.todoes.split(this.todoes.indexOf(x => x.id === todo.id), 1)
            }
            t.isLoading = false
        },
    },
})