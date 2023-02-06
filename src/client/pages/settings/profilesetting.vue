<template>
  <div class="tab-content">
    <div class="grid lg:grid-cols-2 gap-6" @keyup.enter="updateProfile">
      <div>
        <label class="text-white text-sm block cursor-not-allowed">
          {{ $t('firstName') }} *
        </label>
        <input
          v-model="firstName"
          type="text"
          name="firstName"
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
        <label class="text-white text-sm block cursor-not-allowed">
          {{ $t('lastName') }} *
        </label>
        <input
          v-model="lastName"
          type="text"
          name="lastName"
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
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('email') }} *
        </label>
        <input
          v-model="email"
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
            focus:outline-none
          "
        />
      </div>
      <div class="group">
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('country') }} *
        </label>
        <select
          v-model="country_id"
          name="country"
          class="w-full h-12 bg-white text-gray-900 border-r-2 rounded p-1"
        >
          <option value="">Select Country</option>
          <option
            v-for="country in getConstants['countries']"
            :key="country.id"
            :value="country.id"
          >
            {{ country.name }}
          </option>
        </select>
      </div>
      <div>
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('username') }} *
        </label>
        <input
          v-model="username"
          type="text"
          name="username"
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
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('phone') }} *
        </label>
        <input
          v-model="phone"
          type="text"
          name="phone"
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
      <div style="grid-column: 1/-1">
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('address') }} *
        </label>
        <input
          v-model="address"
          type="text"
          name="address"
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
      <div class="group" style="grid-column: 1/-1">
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('address2') }}
        </label>
        <input
          v-model="address2"
          type="text"
          name="address2"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group" style="grid-column: 1/-1">
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('address3') }}
        </label>
        <input
          v-model="address3"
          type="text"
          name="address3"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group">
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('city') }} *
        </label>
        <input
          v-model="city"
          type="text"
          name="city"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group">
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('county') }}
        </label>
        <input
          v-model="county"
          type="text"
          name="county"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
      <div class="group" style="grid-column: 1/-1">
        <label class="text-white text-sm transition-colors duration-300">
          {{ $t('postcode') }} *
        </label>
        <input
          v-model="postcode"
          type="text"
          name="postcode"
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
            focus:border-red
            border-b
            bg-transparent
            focus:outline-none
          "
        />
      </div>
    </div>
    <button class="btn mt-4 mb-4 w-full" type="button" @click="updateProfile()">
      {{ $t('update') }}
    </button>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import swal from 'sweetalert2'
export default {
  name: 'ProfileSettings',
  async asyncData({ store }) {
    await store.dispatch('ConstantStore/getConstants')
  },
  data: () => ({
    firstName: '',
    lastName: '',
    username: '',
    email: '',
    phone: '',
    address: '',
    country_id: '',
    address2: '',
    address3: '',
    city: null,
    county: null,
    postcode: null,
  }),
  computed: {
    ...mapGetters('auth', ['isAuthenticated', 'currentUser', 'userName']),
    ...mapGetters('UserProfileStore', ['errorMessage']),
    ...mapGetters('ConstantStore', ['getConstants']),
  },
  created() {
    this.firstName = this.currentUser.first_name
    this.lastName = this.currentUser.last_name
    this.username = this.currentUser.username
    this.email = this.currentUser.email
    this.phone = this.currentUser.phone
    this.address = this.currentUser.address
    this.country_id = this.currentUser.country.id
    this.address2 = this.currentUser.address2
    this.address3 = this.currentUser.address3
    this.city = this.currentUser.city
    this.county = this.currentUser.county
    this.postcode = this.currentUser.postcode
  },
  methods: {
    ...mapActions('UserProfileStore', ['userProfileUpdate']),
    async updateProfile() {
      if (
        !this.firstName ||
        !this.lastName ||
        !this.username ||
        !this.email ||
        !this.phone ||
        !this.address ||
        !this.country_id ||
        !this.city ||
        !this.postcode
      ) {
        const text = this.$t('required_fields_error')

        swal.fire({
          text,
          type: 'error',
          title: 'Error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      try {
        const payload = {
          first_name: this.firstName,
          last_name: this.lastName,
          username: this.username,
          email: this.email,
          phone: this.phone,
          address: this.address,
          country_id: this.country_id,
          address2: this.address2,
          address3: this.address3,
          city: this.city,
          county: this.county,
          postcode: this.postcode,
        }
        await this.userProfileUpdate(payload)
        const text = this.$t('profile_updated_success')
        swal.fire({
          text,
          type: 'success',
          title: 'Updated Successfully',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
      } catch (e) {
        if (this.errorMessage) {
          let html = ''
          if (typeof this.errorMessage === 'object') {
            Object.entries(this.errorMessage).forEach(([key, value]) => {
              html += value + '<br>'
            })
          } else {
            html = this.errorMessage
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
      }
    },
  },
  head() {
    return { title: this.$t('home') }
  },
}
</script>
