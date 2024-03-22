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
            v-for="todo in todoes"
            @click="todo.done=!todo.done; updateTodo(todo.id)"
            :disabled="todo.isLoading"
            :loading="todo.isLoading"
        >
          <template v-slot:prepend>
              <v-checkbox-btn
                  v-model="todo.done"
                  @change="updateTodo(todo.id)"
              ></v-checkbox-btn>
          </template>

          <v-list-item-title><b>{{ todo.todo }}</b> (<i>{{ todo.list }}</i>)</v-list-item-title>
          <v-progress-linear
            v-if="todo.isLoading"
            color="primary"
            indeterminate></v-progress-linear>

          <template v-slot:append>
            <v-list-item-action end>
              <todo-form
                  :todo="todo"
                  @update="updateTodo(todo.id)"
              ></todo-form>

              <v-btn
                  icon="mdi-delete"
                  size="x-small"
                  variant="tonal"
                  color="orange"
                  @click.stop="confirmDeleteTodo(todo.id)"
              ></v-btn>
            </v-list-item-action>
          </template>
        </v-list-item>
      </v-list>
      <v-footer>
        cose da fare
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
    //
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
    formOpened() {
      this.todo = {...this.emptyTodo}
    }
  },
  created() {
    todoesStore.fetchTodoes()
  },
}
</script>