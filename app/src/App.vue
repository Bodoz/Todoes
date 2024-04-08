<template>
  <v-app>
    <v-app-bar title="Todo List">
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

    <LoginForm
        :show="show_login"
    >
    </LoginForm>
  </v-app>
</template>

<script>
import LoginForm from './components/LoginForm.vue'

export default {
  components: { LoginForm },
  data() {
    return {
      show_login: true,
      links: [
        {to: "/", text: "Home"},
        {to: "/about", text: "About"},
        {to: "/todoes", text: "Todoes"},
      ]
    }
  }
}
</script>