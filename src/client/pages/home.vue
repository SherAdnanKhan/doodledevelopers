<template>
  <card :title="$t('home')">
    {{ $t('you_are_logged_in') }}
  </card>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'Home',
  async fetch({ params, error, payload, store }) {
    await store.dispatch('profile/getProfile')
  },
  computed: {
    ...mapGetters({
      profile: 'profile/profile',
    }),
  },
  head() {
    return { title: this.$t('home') }
  },
}
</script>

<style lang="scss" scoped>
.form-field {
  display: block;
}
</style>
