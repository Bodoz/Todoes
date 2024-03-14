<template>
  <div>
    <v-card
        class="mx-auto"
        max-width="300"
    >
      <v-list>
        <v-list-item
            v-for="todo in todoes"
            key="todo.id"
            :value="todo.id"
            @click="todo.done = !todo.done; updateTodo(todo.id)"
            :disabled="todo.isLoading"
            :loading="todo.isLoading"
        >
          <template v-slot:prepend>
            <v-list-item-action start>
              <v-checkbox-btn
                  v-model="todo.done"
                  @change="updateTodo(todo.id)"
              ></v-checkbox-btn>
            </v-list-item-action>
          </template>
          <v-list-item-title>{{ todo.todo }}</v-list-item-title>
          <v-progress-linear
            v-if="todo.isLoading"
            color="primary"
            indeterminate>
          </v-progress-linear>
          <template v-slot:append>
            <v-btn icon="mdi-edit" size="x-small"
                   @change="">
            </v-btn>
            <v-btn icon="mdi-delete" size="x-small"
                   @change="confirmDeleteTodo(todo.id)">
            </v-btn>
          </template>
        </v-list-item>
      </v-list>
    </v-card>

  <ul>
    <li v-for="todo in todoes"
      :key="todo.id"
    >{{ todo.done }} {{ todo.todo }}</li>
  </ul>

  </div>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useTodoesStore} from "@/stores/todoes.js";

const todoesStore = useTodoesStore()
export default {
  data: () => ({
    //
  }),
  computed: {
    ...mapState(useTodoesStore, ['todoes']),
  },
  methods: {
    ...mapActions(useTodoesStore, ['updateTodo']),
    confirmDeleteTodo() {
      confirm("u schure?") && deleteTodo(id)
    },
  },
  created() {
    todoesStore.fetchTodoes()
  }
}

</script>