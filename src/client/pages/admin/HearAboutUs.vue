<template>
  <div class="flex items-center flex-col">
    <button
      class="
        card-header
        p-3
        rounded rounded-b-none
        text-2xl text-center text-white
        bg-green-700
        focus:outline-none
        w-2/4
        h-a
      "
      @click="toggleModal()"
    >
      + Add New Platform
    </button>

    <div class="flex mt-4 lg:w-2/4">
      <base-table
        class="w-full"
        table-title="How did you hear about us platforms"
        :header-items="headerItems"
        :records="allPlatformsHAU"
        text-color="text-white"
      >
        <template slot="actions" slot-scope="{ item }">
          <div class="flex gap-4">
            <span class="text-xl"
              ><svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                width="25px"
                height="20px"
                @click="editHearAboutUs(item)"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="{2}"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                /></svg
            ></span>
            <span>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                width="25px"
                height="20px"
                @click="delHearAboutUs(item)"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="{2}"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
            </span>
          </div>
        </template>
        <template slot="no-items"> Nothing Found </template>
      </base-table>
    </div>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">Add New Platform</h1>
      </template>
      <template slot="content">
        <div class="max-w-xl flex flex-col w-full" @keyup.enter="performAction">
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Hear About Us Name
            </label>
            <input
              v-model="platformName"
              type="text"
              name="name"
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
            />
          </div>
          <div class="group">
            <label
              class="
                text-white text-xs
                group-focus:text-red-600
                transition-colors
                duration-300
              "
            >
              Hear About Us Label
            </label>
            <input
              v-model="platformLabel"
              type="text"
              name="name"
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
            />
          </div>
          <button
            class="btn mt-5 w-full"
            type="button"
            @click="performAction()"
          >
            {{ buttonText }}
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
  name: 'HearAboutUs',
  layout: 'Admin',
  components: { BaseModal },
  async asyncData({ store }) {
    await store.dispatch('AdminHearAboutUsStore/getAllPlatformsHAU')
  },
  data: () => ({
    buttonText: 'Add hear about us option',
    headerItems: [
      {
        id: 'id',
        name: 'ID',
      },
      {
        id: 'name',
        name: 'Name',
      },
      {
        id: 'label',
        name: 'Label',
      },
      {
        id: 'actions',
        name: 'Actions',
      },
    ],
    modalVisible: false,
    platformName: '',
    platformLabel: '',
    platformId: '',
    isEditMode: false,
  }),
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  computed: {
    ...mapGetters('AdminHearAboutUsStore', [
      'allPlatformsHAU',
      'delMsgHAU',
      'errorMsgAddHAU',
    ]),
  },
  methods: {
    ...mapActions('AdminHearAboutUsStore', [
      'delPlatformsHAU',
      'getAllPlatformsHAU',
      'addPlatformsHAU',
      'editPlatformsHAU',
    ]),
    performAction() {
      if (this.isEditMode) {
        this.editHAUPlatform()
      } else {
        this.addHearAboutUs()
      }
    },
    async delHearAboutUs(payload) {
      if (payload.id) {
        await this.delPlatformsHAU(payload.id)
        const text = this.$t('platform_deleted_successfully')
        swal.fire({
          text,
          type: 'success',
          title: 'Platform Deleted Successfully',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        await this.getAllPlatformsHAU()
      }
    },
    editHearAboutUs(payload) {
      if (payload) {
        this.platformId = payload.id
        this.platformName = payload.name
        this.platformLabel = payload.label
        this.modalVisible = true
        this.isEditMode = true
        this.buttonText = 'Edit hear about us option'
      }
    },
    async editHAUPlatform(payload) {
      if (!this.platformName || !this.platformLabel) {
        const text = this.$t('required_fields_error')
        swal.fire({
          text,
          type: 'error',
          title: 'Fill all Fields',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      try {
        const res = {
          id: this.platformId,
          name: this.platformName,
          label: this.platformLabel,
        }

        await this.editPlatformsHAU(res)
        this.platformLabel = this.platformName = this.platformId = ''
        this.modalVisible = false
        const text = this.$t('platform_edited_successfully')
        swal.fire({
          text,
          type: 'success',
          title: 'Platform Edited Successfully',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        await this.getAllPlatformsHAU()
      } catch (e) {}
    },
    async addHearAboutUs() {
      if (!this.platformName || !this.platformLabel) {
        const text = this.$t('required_fields_error')
        swal.fire({
          text,
          type: 'error',
          title: 'Fill all Fields',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      try {
        const res = {
          name: this.platformName,
          label: this.platformLabel,
        }
        await this.addPlatformsHAU(res)
        this.platformLabel = this.platformName = ''
        this.modalVisible = false
        const text = this.$t('platform_added_successfully')
        swal.fire({
          text,
          type: 'success',
          title: 'Platform Added Successfully',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        await this.getAllPlatformsHAU()
      } catch (e) {}
    },
    toggleModal() {
      this.modalVisible = true
      this.isEditMode = false
      this.buttonText = 'Add hear about us option'
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

<style></style>
