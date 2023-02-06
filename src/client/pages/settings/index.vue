<template>
  <div class="lg:w-1/2 mx-auto py-4 min-h-screen bg-black px-4 w-full">
    <nav class="tabs flex items-center justify-center mb-8 text-grey">
      <nuxt-link
        :to="{ name: 'profileSettings.profile' }"
        class="
          tab
          py-2
          border-b
          lg:hover:border-red lg:hover:text-white
          transition
          duration-500
          cursor-pointer
        "
        :class="{
          'border-red text-white': $nuxt.$route.name.includes(
            'profileSettings.profile'
          ),
        }"
      >
        {{ $t('personal_profile') }}
      </nuxt-link>
      <nuxt-link
        :to="{ name: 'profileSettings.password' }"
        class="
          tab
          ml-6
          py-2
          border-b
          lg:hover:border-red lg:hover:text-white
          transition
          duration-500
          cursor-pointer
        "
        :class="{
          'border-red text-white': $nuxt.$route.name.includes(
            'profileSettings.password'
          ),
        }"
      >
        {{ $t('change_password') }}
      </nuxt-link>
    </nav>
    <div v-if="isAuthenticated" class="text-center">
      <div
        class="
          rounded-full
          h-24
          w-24
          bg-white
          m-auto
          bg-no-repeat bg-center
          cursor-pointer
        "
        :style="{
          backgroundImage: `url(${profileImage})`,
          backgroundSize: 'cover',
        }"
        @click="addProfileImage()"
      />
      <h3 class="text-red-600 text-xl mt-3 mb-3">
        {{ userName }}
      </h3>
      <p class="text-white text-md mb-16">
        {{ currentUser.email }}
      </p>
    </div>
    <transition name="fade" mode="out-in">
      <nuxt-child />
    </transition>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">{{ modalTitle }}</h1>
      </template>
      <template slot="content">
        <div
          class="max-w-xl flex flex-col w-full"
          @keyup.enter="updateProfileImage"
        >
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Image
            </label>
            <input
              ref="file"
              type="file"
              name="file"
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
                group-focus:border-red
                focus:outline-none focus:border-red
              "
              required
              @change="documentSelected()"
            />
          </div>
          <button
            class="btn mt-5 w-full"
            type="button"
            @click="updateProfileImage()"
          >
            {{ modalTitle }}
          </button>
        </div>
      </template>
    </base-modal>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import swal from 'sweetalert2'
import BaseModal from '~/components/Shared/BaseModal.vue'

export default {
  components: { BaseModal },
  data: () => ({
    modalVisible: false,
    modalTitle: 'Upload Image',
    image: require('~/assets/images/user.png'),
    validTypes: ['image/png', 'image/jpg', 'image/jpeg'],
  }),
  layout: 'User',
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  computed: {
    tabs() {
      return [
        {
          name: this.$t('User profile'),
          route: 'settings.profile',
        },
        {
          name: this.$t('Business profile'),
          route: 'settings.BusinessProfile',
        },
        {
          name: this.$t('Service Focus Bar'),
          route: 'settings.ServiceFocus',
        },
        {
          name: this.$t('password'),
          route: 'settings.password',
        },
      ]
    },
    profileImage() {
      return this.currentUser.profile_image ?? this.image
    },
    ...mapGetters('auth', ['isAuthenticated', 'currentUser', 'userName']),
    ...mapGetters('UserProfileStore', ['errorMessage']),
  },
  methods: {
    ...mapActions('UserProfileStore', ['userProfileUpdate']),
    addProfileImage() {
      this.modalVisible = true
    },
    documentSelected(e) {
      this.document = this.$refs.file.files[0]
      this.isValidFile(this.document)
      this.documentName = this.document.name
      const reader = new FileReader()
      reader.onload = (e) => {
        this.image = reader.result
      }
      reader.readAsDataURL(this.document)
    },
    isValidFile(file) {
      const isValidType = this.validTypes.includes(file.type)
      if (!isValidType) {
        swal.fire({
          text: 'File must be of type png, jpg, jpeg.',
          type: 'error',
          title: 'Error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return false
      }
      return true
    },
    async updateProfileImage(e) {
      if (!this.document) {
        swal.fire({
          text: 'Please select an image to upload',
          type: 'warning',
          title: 'Select image',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      if (this.document && this.isValidFile(this.document)) {
        try {
          const payload = {
            profile_image: this.image,
          }
          await this.userProfileUpdate(payload)
          const text = this.$t('profile_image_uploaded_success')
          swal.fire({
            text,
            type: 'success',
            title: 'Uploaded Successfully',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
          })
          this.modalVisible = false
        } catch (e) {
          if (this.errorMessage) {
            let text = ''
            if (typeof this.errorMessage === 'object') {
              text = this.errorMessage[Object.keys(this.errorMessage)[0]]
            } else {
              text = this.errorMessage
            }
            swal.fire({
              text,
              type: 'error',
              title: 'Error',
              confirmButtonText: 'Ok',
              cancelButtonText: 'Cancel',
            })
            return false
          }
        }
      }
    },
    escEvent(e) {
      if (e.key === 'Escape' && this.modalVisible === true) {
        this.modalVisible = false
      }
    },
  },
  destroyed() {
    window.removeEventListener('keyup', this.escEvent)
  },
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
