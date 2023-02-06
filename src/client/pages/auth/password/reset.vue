<template>
  <div
    v-show="show"
    class="container mx-auto py-12 px-6 lg:px-0 min-h-screen bg-black"
  >
    <div>
      <h1 class="text-red-600 text-center font-semibold text-2xl mb-6">
        Reset Password
      </h1>
      <p class="text-white text-sm text-center mb-16">
        Enter your new password below
      </p>
    </div>
    <div class="flex items-center">
      <form
        class="w-full"
        @submit.prevent="reset"
        @keydown="form.onKeydown($event)"
      >
        <alert-success :form="form" :message="status" />
        <!-- Email -->
        <div class="group">
          <label
            class="
              text-white text-xs
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

        <!-- Password -->
        <div class="form-group row">
          <label
            class="
              text-white text-xs
              group-focus:text-red-600
              transition-colors
              duration-300
            "
          >
            {{ $t('password') }}
          </label>
          <input
            v-model="form.password"
            :class="{ 'is-invalid': form.errors.has('password') }"
            type="password"
            name="password"
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
          <has-error :form="form" field="password" />
        </div>

        <!-- Password Confirmation -->
        <div class="form-group row">
          <label
            class="
              text-white text-xs
              group-focus:text-red-600
              transition-colors
              duration-300
            "
          >
            {{ $t('confirm_password') }}
          </label>
          <input
            v-model="form.password_confirmation"
            :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
            type="password"
            name="password_confirmation"
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
          <has-error :form="form" field="password_confirmation" />
        </div>

        <!-- Submit Button -->
        <div class="mt-4 text-center">
          <v-button
            :loading="form.busy"
            class="
              text-red-600
              hover:text-red-300
              transition-colors
              duration-300
              inline-block
              text-xs
              w-full
            "
          >
            {{ $t('reset_password') }}
          </v-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import swal from 'sweetalert2'
import { mapActions, mapGetters } from 'vuex'

export default {
  data: () => ({
    status: '',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: '',
    }),
    show: false,
  }),
  created() {
    this.form.token = this.$route.params.token
    this.validateToken()
  },
  computed: {
    ...mapGetters('auth', ['errorMessage']),
  },
  methods: {
    ...mapActions('auth', ['validateForgetPasswordToken', 'resetPassword']),
    async reset() {
      try {
        const payload = {
          token: this.form.token,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation,
        }
        await this.resetPassword(payload)
        const text = this.$t('forget_password_reset_success')
        swal.fire({
          text,
          type: 'success',
          title: 'Forget Password',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        // Redirect to login.
        await this.$router.push({ path: '/login' })
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
    async validateToken() {
      try {
        const payload = {
          token: this.form.token,
        }
        await this.validateForgetPasswordToken(payload)
        this.show = true
      } catch (e) {
        swal.fire({
          text: 'Invalid token or link expired!',
          type: 'error',
          title: 'Error',
          showCancelButton: false,
          showConfirmButton: false,
          allowOutsideClick: false,
        })
        return false
      }
    },
  },
  head() {
    return { title: this.$t('reset_password') }
  },
}
</script>
