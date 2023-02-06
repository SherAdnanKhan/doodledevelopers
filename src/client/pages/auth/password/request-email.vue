<template>
  <div
    class="
      container
      mx-auto
      pt-24
      pb-12
      px-6
      min-h-screen
      bg-black
      flex flex-col
      items-center
      justify-center
    "
  >
    <div class="max-w-xl flex flex-col w-full">
      <div class="flex items-center">
        <form
          class="w-full"
          @submit.prevent="send"
          @keydown="form.onKeydown($event)"
        >
          <div class="w-80 max-w-xs m-auto">
            <img src="~/assets/svg/logo-strap.svg" alt="Red6Six logo" />
            <h1 class="text-white text-2xl mb-4 text-center mt-8">
              Forgot Password
            </h1>
            <p class="text-white text-center mb-16">
              Enter the email address you used to create your account and we
              will email you a link to reset your password
            </p>
          </div>
          <alert-success :form="form" :message="status" />
          <div class="group">
            <label
              class="
                text-white
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              {{ $t('email') }}
            </label>
            <input
              v-model="form.email"
              :class="{ 'is-invalid': form.errors.has('email') }"
              type="email"
              name="email"
              required
              class="
                bg-brand
                text-white
                px-2
                h-8
                mt-4
                mb-4
                w-full
                border-white
                transition-colors
                duration-300
                border-b
                bg-transparent
                group-focus:border-red-600
                focus:outline-none
              "
            />
            <has-error :form="form" field="email" />
          </div>
          <div class="mt-4 text-center">
            <v-button
              :loading="form.busy"
              class="
                text-red
                hover:text-red-300
                transition-colors
                duration-300
                inline-block
                w-full
              "
            >
              {{ $t('send_password_reset_link') }}
            </v-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import Form from 'vform'
import swal from 'sweetalert2'
import { mapGetters, mapActions } from 'vuex'

export default {
  data: () => ({
    status: '',
    form: new Form({
      email: '',
    }),
  }),
  computed: {
    ...mapGetters('auth', ['errorMessage']),
  },
  methods: {
    ...mapActions('auth', ['forgetPassword']),
    async send() {
      try {
        const payload = {
          email: this.form.email,
        }
        await this.forgetPassword(payload)
        const text = this.$t('forget_password_success')
        swal.fire({
          text,
          type: 'success',
          title: 'Forget Password',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        this.form.email = ''
      } catch (e) {
        let html = ''
        if (typeof e === 'object') {
          Object.entries(e).forEach(([key, value]) => {
            html += value + '<br>'
          })
        } else {
          html = e
        }
        swal.fire({
          html,
          type: 'error',
          title: 'Error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return false
      }
    },
    head() {
      return { title: this.$t('reset_password') }
    },
  },
}
</script>
