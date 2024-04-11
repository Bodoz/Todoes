<template>
  <div>
    <v-card
        class="mx-auto"
        max-width="600"
        elevation="5"
    >
      <v-toolbar>
        <template v-slot:prepend>
          <v-icon icon="mdi-format-list-checks"></v-icon>
        </template>
        <v-toolbar-title> The best of all the worlds' to-do's list</v-toolbar-title>
        <template v-slot:append>
          <todo-form
              :todo="todo"
              @update="newTodo(todo)"
              @opened="formOpened"
              icon="mdi-plus"
              title="Add a new to-do"
              size="default"
          ></todo-form>
        </template>
      </v-toolbar>

<!--      key="todo.id"-->
<!--      :value="todo.id"-->

      <v-list>
        <v-list-item
            v-for="t in todoes"
            @click="t.done=!t.done; updateTodo(t)"
            :disabled="t.isLoading"
            :loading="t.isLoading"
        >
          <template v-slot:prepend>
              <v-checkbox-btn
                  v-model="t.done"
                  @change="updateTodo(t)"
              ></v-checkbox-btn>
          </template>

          <v-list-item-title><b>{{ t.todo }}</b> (<i>{{ t.list }}</i>)</v-list-item-title>
          <v-progress-linear
            v-if="t.isLoading"
            color="primary"
            indeterminate></v-progress-linear>

          <template v-slot:append>
            <v-list-item-action end>
              <todo-form
                  :todo="todo"
                  @update="updateTodo(todo)"
                  @opened="formOpened(t)"
              ></todo-form>

              <v-btn
                  icon="mdi-delete"
                  size="x-small"
                  variant="tonal"
                  color="red"
                  @click.stop="confirmDeleteTodo(t.id)"
              ></v-btn>
            </v-list-item-action>
          </template>
        </v-list-item>
      </v-list>
      <v-footer>
        elenchi di cose da fare
      </v-footer>
    </v-card>

  </div>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useTodoesStore} from "@/stores/todoes.js";
import TodoForm from "@/components/TodoForm.vue";

const todoesStore = useTodoesStore()
export default {
  components: {TodoForm},
  data: () => ({
    emptyTodo: {
      todo: '',
      done: false,
      id_list: '',
    },
    todo: null,
  }),
  computed: {
    ...mapState(useTodoesStore, ['todoes']),
  },
  methods: {
    ...mapActions(useTodoesStore, ['updateTodo', 'deleteTodo', 'newTodo']),

    confirmDeleteTodo(id) {
      (confirm("sei sicuro di cancellare questo to-do?")) && this.deleteTodo(id)
    },
    alert(){
      alert(...arguments)
      console.log(...arguments)
    },
    addTodo(){
      let todo = prompt("Digita il nuovo impegno: ")
      this.newTodo(todo)
    },
    formOpened(t) {
      if(t){
        this.todo = {...t}
      }else{
        this.todo = {...this.emptyTodo}
      }
    }
  },
  created() {
    todoesStore.fetchTodoes()
  },
}
</script>