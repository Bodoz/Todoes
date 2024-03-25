<template>
    <v-dialog
        max-width="600"
        persistent
        :model="dialog"
    >
      <v-card
          prepend-icon="mdi-account"
          title="User Profile"
      >
      </v-card>
    </v-dialog>
</template>

<script>
export default {
  props: {
    show: Boolean,
  },
  data: () => ({
    //dialog: false,
  }),
  computed: {
    dialog() {
      return this.show
    },
  },
}
</script>