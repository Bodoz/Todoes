<template>
  <div class="pa-4 text-center">
    <v-dialog
        max-width="600"
        persistent
        v-model="dialog"
    >
      <v-card
          prepend-icon="mdi-account"
          title="Login"
      >
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
        <v-card-actions class="px-4 pb-5">
          <v-spacer></v-spacer>
          <v-btn
              type="submit"
              color="primary"
          >Login</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
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
    dialog() {
      return this.show
    }
  }
}
</script>