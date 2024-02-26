<template>
    <v-card
        class="mx-auto"
        max-width="300"
    >
      <v-list :items="todoes"
              item-title="todo"
              item-value="id"
      ></v-list>
    </v-card>

  <ul>
    <li v-for="todo in todoes"
      :key="todo.id"
    >{{ todo.todo }}</li>
  </ul>
</template>

<script>
import {mapState} from "pinia";
import {useTodoesStore} from "@/stores/todoes.js";

const store = useTodoesStore()
export default {
  data: () => ({
    //
  }),
  computed: {
    ...mapState(useTodoesStore, ['todoes']),
  },
  mounted() {
    store.fetchTodoes()
  }
}

</script>