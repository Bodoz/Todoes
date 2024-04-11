<template>
  <v-app>
    <v-app-bar title="Todo List">
      <v-btn
          @click="login"
      >{{ logged }}</v-btn>
      <v-tabs>
        <v-tab
            color="indigo"
            v-for="link in links"
            :to="link.to"
        >{{ link.text }}</v-tab>
      </v-tabs>
    </v-app-bar>

    <v-main>
      <v-container>
        <v-sheet class="ma-2 pa-2">
          <RouterView />

        </v-sheet>
      </v-container>
    </v-main>

    <LoginForm></LoginForm>
  </v-app>
</template>

<script>
import LoginForm from './components/LoginForm.vue'
import {mapActions, mapState, mapWritableState} from "pinia";
import {useUsersStore} from "@/stores/users.js";

export default {
  components: { LoginForm },
  data() {
    return {
      links: [
        {to: "/", text: "Home"},
        {to: "/about", text: "About"},
        {to: "/todoes", text: "Todoes"},
      ]
    }
  },
  computed: {
    logged() {
      return this.user ? "Logout" : "Login"
    },
    ...mapState(useUsersStore, ['user']),
    ...mapWritableState(useUsersStore, ['show_login']),
  },
  methods: {
    ...mapActions(useUsersStore, ['authorized', 'authorize']),

    login() {
      if (this.user){
        this.authorize()
      } else {
        this.show_login = true
      }
    },
  },
  beforeMount() {
    this.authorized()
  }
}
</script>