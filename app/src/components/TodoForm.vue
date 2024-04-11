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
                    v-model="todo.id_list"
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
      return this.todo.todo.trim() !== '' && this.todo.id_list > 0
    }
  },
  methods: {
    saveTodo(){
      if(this.dataVerified){
        this.todo.todo = this.todo.todo.trim()
        this.$emit('update')
        this.dialog = false
      }
    }
  },
  beforeMount() {
    todoesStore.fetchLists()
  },
}
</script>