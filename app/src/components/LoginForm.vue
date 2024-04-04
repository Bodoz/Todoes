<template>
    <v-dialog
        max-width="600"
        :model="dialog"
        persistent
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
                    md="4"
                >
                  <v-text-field
                      v-model="username"
                      :counter="32"
                      :rules="usernameRules"
                      label="username"
                      required
                  ></v-text-field>
                </v-col>

                <v-col
                    cols="12"
                    md="4"
                >
                  <v-text-field
                      v-model="password"
                      :counter="16"
                      :rules="passwordRules"
                      label="password"
                      required
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-form>
        </v-card-text>
        <v-card-actions class="px-10 pb-6">
          <v-spacer></v-spacer>
          <v-btn type="submit"
                 color="primary"
                 variant="elevated"
                 class="px-4"
          >Login</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>

<script>
export default {
  props: {
    dialog: Boolean,
  },
  //dialog: false,
  data: () => ({
    valid: false,
    username: '',
    password: '',
    usernameRules: [
      value => {
        if (value) return true
        else return 'username is required.'
      },
    ],
    passwordRules: [
      value => {
        if (value && value?.trim().length > 0) return true
        else return 'password is required too.'
      },
    ],
  }),
  computed: {
    dialog() {
      return this.show
    },
  },
}
</script>