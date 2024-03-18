<template>
    <div class="px-3 text-center">
      <v-dialog
          v-model="dialog"
          max-width="600"
      >
        <template v-slot:activator="{ props: activatorProps }">
          <v-btn
              size="x-small"
              icon="mdi-pencil"
              v-bind="activatorProps"
          ></v-btn>
        </template>

        <v-card
            prepend-icon="mdi-pencil"
            title="New or edit Todo"
        >
          <v-card-text>
            <v-row dense>
              <v-col
                  cols="12"
                  md="8"
              >
                <v-text-field
                    v-model="local_todo"
                    x-label="Type here your todoes*"
                    required
                ></v-text-field>

              </v-col>

              <v-col
                  cols="12"
                  md="4"
              >
                <v-select
                    v-model="local_list_id"
                    :items="lists"
                    item-title="list"
                    item-value="id"
                    x-label="List*"
                    required
                    @update:model-value="console.log(local_list_id)"
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
                @click="saveTodo()"
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
    id: Number,
    todo: String,
    done: Boolean,
    list_id: Number,
  },
  //emits: [
  //  'update:todo',
  //  'update:done',
  //  'update:list_id',
  //],
  data: () => ({
    local_todo: '',
    local_list_id: 0,
    dialog: false,
  }),
  computed: {
    ...mapState(useTodoesStore, ['todoes', 'lists']),
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