<template>
  <div class="pa-4 text-center">
    <v-dialog
        max-width="600"
        persistent
        v-model="show_login"
    >
      <v-card
          prepend-icon="mdi-account"
          title="Login"
      >
        <v-card-text>
        <v-form v-model="valid">
          <v-container>
            <v-row>
              <v-col
                  cols="12"
                  md="6"
              >
                <v-text-field
                    v-model="username"
                    :counter="32"
                    maxlength="32"
                    :rules="usernameRules"
                    label="Username"
                    required
                ></v-text-field>
              </v-col>

              <v-col
                  cols="12"
                  md="6"
              >
                <v-text-field
                    v-model="password"
                    :counter="16"
                    maxlength="16"
                    :rules="passwordRules"
                    label="Password"
                    required
                ></v-text-field>
                <!-- il max length non serve nel login quanto nel signup -->
              </v-col>
            </v-row>
          </v-container>
        </v-form>
        </v-card-text>
        <v-card-actions class="px-10 pb-6">
          <v-spacer></v-spacer>
          <v-btn
              type="submit"
              variant="elevated"
              class="px-4 mr-3"
              @click="cancel"
          >Annulla</v-btn>
          <v-btn
              type="submit"
              color="primary"
              variant="elevated"
              class="px-4"
              @click="login"
              :disabled="!valid"
          >Login</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import {mapActions, mapState, mapWritableState} from "pinia";
import {useUsersStore} from "@/stores/users.js";

export default {
  props: {
    show: Boolean,
  },
  data: () => ({
    valid: false,
    username: '',
    password: '',
    usernameRules: [
      (value) => {
        if (value && value?.trim().length > 0) return true // anche senza value
        else return 'Username is required.'                // per il value? che sostituisce
      },
    ],
    passwordRules : [
      (value) => {
        if (value && value?.trim().length > 0) return true
        else return 'Password is required.'
      },
    ],
  }),
  computed: {
    ...mapState(useUsersStore, ['user']),
    ...mapWritableState(useUsersStore, ['show_login']),
  },
  methods: {
    ...mapActions(useUsersStore, ['authorize']),
    login(){
      if(this.valid){
        this.authorize({username: this.username, password: this.password})
      }
    },
    cancel(){
      this.show_login = false
    }
  },
}
</script>