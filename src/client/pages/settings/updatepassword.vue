<template>
  <div class="py-4 min-h-screen bg-black">
    <div class="grid gap-6" @keyup.enter="updatePassword">
      <div>
        <label class="text-white block">
          {{ $t('current_password') }}
        </label>
        <input
          v-model="currentPassword"
          type="password"
          name="currentPassword"
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
            focus:outline-none
          "
        />
      </div>
      <div>
        <label class="text-white block">
          {{ $t('new_password') }}
        </label>
        <input
          v-model="newPassword"
          type="password"
          name="newPassword"
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
            focus:border-red-600
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div>
        <label class="text-white transition-colors duration-300 block">
          {{ $t('confirm_password') }}
        </label>
        <input
          v-model="confirmPassword"
          type="password"
          name="confirmPassword"
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
            focus:outline-none
          "
        />
      </div>
    </div>
    <button
      class="btn mt-4 mb-4 w-full"
      type="button"
      @click="updatePassword()"
    >
      {{ $t('update') }}
    </button>
  </div>
</template>

<script>
import swal from 'sweetalert2'
export default {
  name: '',

  data: () => ({
    currentPassword: '',
    newPassword: '',
    confirmPassword: '',
  }),
  methods: {
    async updatePassword() {
      try {
        const payload = {
          password: this.currentPassword,
          new_password: this.newPassword,
          confirm_password: this.confirmPassword,
        }
        await this.$store.dispatch(
          'UserProfileStore/userPasswordUpdate',
          payload
        )
        const text = this.$t('password_updated_success')
        swal.fire({
          text,
          type: 'success',
          title: 'Updated Successfully',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
      } catch (e) {}
    },
  },
}
</script>
