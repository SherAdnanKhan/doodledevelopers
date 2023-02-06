<template>
  <div class="px-4 pb-4">
    <div class="flex card-button">
      <button
        class="
          card-button
          py-4
          px-8
          mb-4
          capitalize
          text-center
          bg-gold
          lg:hover:bg-red lg:hover:text-white
          text-black
          focus:outline-none
          right-0
          relative
          ml-auto
        "
        @click="createTicket()"
      >
        Create Support Request
      </button>
    </div>
    <div>
      <h1 class="text-white text-2xl mb-4 text-center mt-4">All Support Requests</h1>
      <div class="grid lg:grid-cols-2 gap-4 max-w-3xl mx-auto">
        <div
          v-for="(item, index) in getAllUserSupportTickets"
          :key="index"
          class="game-card flex flex-col cursor-pointer"
        >
          <div class="game-card-body p-4 flex-1">
            <h2 class="font-bold text-white text-2xl">
              {{ item.title }}
            </h2>
            <span class="flex flex-row items-center mt-2">
              <div class="inline-block mr-2">
                <div class="flex mb-2 flex-col">
                  <span class="text-gold font-semibold mr-2">Description:</span>
                  <span class="text-white">{{
                    item.description.substring(0, 70) + '....'
                  }}</span>
                </div>
                <div class="flex mb-2">
                  <span class="text-gold font-semibold mr-2">Status:</span>
                  <span class="text-white">{{ item.status.name }}</span>
                </div>
                <div class="flex flex-col">
                  <span class="text-gold font-semibold mr-2 mb-2"
                    >Actions:</span
                  >
                  <template>
                    <div class="flex gap-4">
                      <button
                        class="
                          inline
                          bg-yellow-500
                          h-8
                          mr-2
                          text-md
                          bg-opacity-75
                          text-black
                          rounded
                          px-4
                          py-1
                          focus:outline-none
                        "
                        type="button"
                        @click.stop="showDetails(item)"
                      >
                        Details
                      </button>
                      <span class="text-xl flex"
                        ><svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          width="25px"
                          height="20"
                          class="my-auto"
                          @click="editSupportTicket(item)"
                        >
                          <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="{2}"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                          /></svg
                      ></span>
                      <span class="text-xl flex">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          width="25px"
                          height="20px"
                          class="my-auto"
                          @click="deleteSupportTicket(item)"
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
                </div>
              </div>
            </span>
          </div>
        </div>
      </div>
    </div>
    <base-modal :showing="modalVisible" @close="modalVisible = false">
      <template slot="title">
        <h1 class="text-white text-2xl mb-4">{{ modalTitle }}</h1>
      </template>
      <template slot="content">
        <div class="max-w-xl flex flex-col w-full" @keyup.enter="toggleModal">
          <div v-if="isEdit === true">
            <div class="group">
              <label
                class="
                  text-white text-xs
                  group-focus:text-red-600
                  transition-colors
                  duration-300
                "
              >
                Status
              </label>
              <select
                id="editTicket"
                v-model="editTicket"
                name="editTicket"
                class="w-full p-4 text-black"
              >
                <option value="">Select Status</option>
                <option value="inrevision">Open</option>
                <option value="closed">Closed</option>
              </select>
            </div>
          </div>
          <div v-if="isCreate === true">
            <div class="group">
              <label
                class="
                  text-white text-xs
                  group-focus:text-red-600
                  transition-colors
                  duration-300
                "
              >
                Title
              </label>
              <input
                v-model="ticketTitle"
                type="text"
                name="ticketTitle"
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
                Description
              </label>
              <textarea
                v-model="ticketDescription"
                type="text"
                name="ticketDescriptionticketDescription"
                rows="3"
                class="
                  bg-brand
                  text-white
                  px-2
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
          </div>
          <button class="btn mt-5 w-full" type="button" @click="toggleModal()">
            Submit
          </button>
        </div>
      </template>
    </base-modal>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import swal from 'sweetalert2'
import BaseModal from '~/components/Shared/BaseModal.vue'
export default {
  name: 'UserSupport',
  layout: 'User',
  components: { BaseModal },
  async asyncData({ store }) {
    await store.dispatch('UserSupportStore/getUserSupportTickets')
  },
  data: () => ({
    headerItems: [
      {
        id: 'title',
        name: 'Subject',
      },
      {
        id: 'description',
        name: 'Description',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'actions',
        name: 'Actions',
      },
    ],
    modalVisible: false,
    modalTitle: 'Edit Support Request',
    editTicket: '',
    ticketId: '',
    isEdit: false,
    isCreate: false,
    ticketTitle: '',
    ticketDescription: '',
  }),
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  computed: {
    ...mapGetters('UserSupportStore', [
      'getAllUserSupportTickets',
      'editUserTicket',
      'errorSupportMessage',
      'createUserTicket',
    ]),
  },
  methods: {
    ...mapActions('UserSupportStore', [
      'getUserSupportTickets',
      'editUserSupportTicket',
      'deleteUserSupportTicket',
      'createUserSupportTicket',
    ]),
    showDetails(payload) {
      this.$router.push({
        name: 'user-ticket-details',
        params: { id: payload.id },
      })
    },
    editSupportTicket(payload) {
      this.modalTitle = 'Edit Support Request'
      this.ticketId = payload.id
      this.isCreate = false
      this.isEdit = true
      this.modalVisible = true
    },
    async onEditTicket() {
      if (this.editTicket === '') {
        const text = 'Please Select Status'
        swal.fire({
          text,
          type: 'error',
          title: 'Select Status',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return false
      }
      const payload = {
        id: this.ticketId,
        status: this.editTicket,
      }
      try {
        await this.editUserSupportTicket(payload)
        this.isEdit = this.modalVisible = false
        const text = 'Status updated succesfully'
        swal.fire({
          text,
          type: 'success',
          title: 'Updated',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        await this.getUserSupportTickets()
      } catch (e) {
        if (this.errorSupportMessage) {
          const text = this.errorSupportMessage
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
    },
    async deleteSupportTicket(payload) {
      try {
        const result = await swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#DBBA6B',
          cancelButtonColor: '#d70000',
          confirmButtonText: 'Yes, delete it!',
        })
        if (result.value) {
          this.ticketId = payload.id
          await this.deleteUserSupportTicket(this.ticketId)
          const text = 'Support Request Deleted Successfully'
          swal.fire({
            text,
            type: 'success',
            title: 'Deleted',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
          })
          await this.getUserSupportTickets()
        }
      } catch (e) {
        if (this.errorSupportMessage) {
          const text = this.errorSupportMessage
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
    },
    createTicket() {
      this.modalTitle = 'Create Support Request'
      this.isEdit = false
      this.isCreate = true
      this.modalVisible = true
    },
    async onCreateTicket() {
      if (!this.ticketTitle || !this.ticketDescription) {
        const text = 'All fields are mandatory'
        swal.fire({
          text,
          type: 'error',
          title: 'Validation error',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return
      }
      const payload = {
        title: this.ticketTitle,
        description: this.ticketDescription,
      }
      try {
        await this.createUserSupportTicket(payload)
        this.modalVisible = this.isCreate = false
        this.ticketTitle = ''
        this.ticketDescription = ''
        const text = 'Support Request Created Successfully'
        swal.fire({
          text,
          type: 'success',
          title: 'Create Support Request',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        await this.getUserSupportTickets()
      } catch (e) {
        if (this.errorSupportMessage) {
          const text = this.errorSupportMessage
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
    },
    toggleModal() {
      if (this.isEdit === true) {
        this.onEditTicket()
      } else {
        this.onCreateTicket()
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

<style></style>
