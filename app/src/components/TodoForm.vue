<template>
    <div class="px-3 text-center">
      <v-dialog
          v-model="dialog"
          max-width="600"
          persistent
      >
        <template v-slot:activator="{ props: activatorProps }">
          <v-btn
              v-bind="activatorProps"
              variant="tonal"
              color="primary"
              density="default"
              :size="size"
              :icon="icon"
              @click="$emit('opened')"
          ></v-btn>
        </template>

        <v-card
            :prepend-icon="icon"
            :title="title"
        >
          <v-card-text>
            <v-row dense>
              <v-col
                  cols="12"
                  md="8"
              >
                <v-text-field
                    v-model="todo.todo"
                    x-label="Type here your todoes*"
                    required
                ></v-text-field>
              </v-col>

              <v-col
                  cols="12"
                  md="4"
              >
                <v-select
                    v-model="todo.list_id"
                    :items="lists"
                    item-title="list"
                    item-value="id"
                    x-label="List*"
                    required
                ></v-select>
              </v-col>
            </v-row>

            <small class="text-caption text-medium-emphasis">*indicates required field</small>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
                text="Close"
                variant="plain"
                @click="dialog = false"
            ></v-btn>

            <v-btn
                color="primary"
                text="Save"
                variant="tonal"
                @click="saveTodo"
                :disable="!dataVerified"
            ></v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
</template>

<script>
import {mapActions, mapState} from "pinia";
import {useTodoesStore} from "@/stores/todoes.js";
import {id} from "vuetify/locale";

const todoesStore = useTodoesStore()
export default {
  name: "TodoForm",
  props: {
    todo: Object,
    icon: {
      type: String,
      default(){
        return 'mdi-pencil'
      }
    },
    title: {
      type: String,
      default(){
        return "Modify this to-do"
      }
    },
    size: {
      type: String,
      default(){
        return 'x-small'
      }
    },
  },
  emits: ['update', 'opened'],
  data: () => ({
    dialog: false,
  }),
  computed: {
    ...mapState(useTodoesStore, ['todoes', 'lists']),
    dataVerified(){
      return ths.todo.todo.trim() !== '' && this.todo.id_list > 0
    }
  },
  methods: {
  //  ...mapActions(useTodoesStore, ['']),
    saveTodo(){
      let ix = this.todoes.indexOf(x => x.id === this.id)
      for (ix in this.todoes) if(this.todoes[ix].id === this.id) break;
      this.todoes[ix].todo = this.local_todo
      this.todoes[ix].list_id = this.local_list_id
      todoesStore.updateTodo(this.id)
      this.dialog = false
    }
  },
  mounted() {
    this.local_todo =this.todo
    this.local_list_id = this.list_id
  },
  created() {
    todoesStore.fetchLists()
  },
}
</script>

<style scoped>

</style>