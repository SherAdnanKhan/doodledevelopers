<template>
  <div class="container lg:px-8 mx-auto rounded-lg">
    <div class="card-header bg-green-400 p-4 font-bold">
      <div class="flex">
        <div class="text-3xl text-white">
          {{ getAdminSupportTicketDetails.title.toUpperCase() }}
        </div>
      </div>
      <div class="flex">
        <div class="text-md text-white">
          {{ getAdminSupportTicketDetails.description }}
        </div>
      </div>
    </div>
    <div class="card-header border bg-white p-4 items-center shadow-lg">
      <template
        v-if="
          getAdminSupportTicketDetails.messages &&
          getAdminSupportTicketDetails.messages.length
        "
      >
        <TicketDetails :user-message="getAdminSupportTicketDetails.messages"
      /></template>
      <div v-else>
        <h1 class="text-orange-700 text-center text-xl py-16">
          This is the start of your conversation <br />
          Type a message to follow up
        </h1>
      </div>
    </div>
    <div
      class="card-header bg-white items-center flex gap-2 p-4 justify-between"
      @keyup.enter="ticketUpdate"
    >
      <select
        id="ticketStatus"
        v-model="ticketStatus"
        name="ticketStatus"
        class="
          text-gray-700
          w-2/4
          bg-white
          border-gray-500
          rounded-full
          border-2
          p-3
          focus:border-gray-600 focus:outline-none
        "
      >
        <option value="">Select Status</option>
        <option value="inprogress">In Progress</option>
        <option value="resolved">Resolved</option>
      </select>
      <input
        v-model="supportMessage"
        type="text"
        name="supportMessage"
        placeholder="Type message..."
        class="
          text-gray-700
          w-3/4
          border-gray-500
          rounded-full
          focus:outline-none focus:shadow-outline
          border-2
          p-3
          focus:border-gray-600
        "
      />
      <button
        :disabled="getAdminSupportTicketDetails.status.id === 'closed'"
        class="rounded-full font-bold border-2 text-white w-1/6 p-3 ml-auto"
        :class="
          getAdminSupportTicketDetails.status.id === 'closed'
            ? 'cursor-not-allowed bg-green-400'
            : 'bg-green-400 border-green-600'
        "
        @click="updateTicket"
      >
        Send
      </button>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import swal from 'sweetalert2'
import TicketDetails from '~/components/Admin/TicketDetails.vue'
export default {
  name: 'AdminTicketDetails',
  layout: 'Admin',
  components: { TicketDetails },
  async asyncData({ store, route }) {
    await store.dispatch(
      'AdminSupportStore/getAdminTicketDetails',
      route.params.id
    )
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
    supportMessage: '',
    btnStatus: '',
    ticketStatus: '',
  }),
  computed: {
    ...mapGetters('AdminSupportStore', [
      'getAdminSupportTicketDetails',
      'updateAdminSupportTicketDetails',
    ]),
  },
  methods: {
    ...mapActions('AdminSupportStore', [
      'getAdminTicketDetails',
      'updateAdminTicketDetails',
    ]),
    async updateTicket() {
      if (this.supportMessage === '' || this.ticketStatus === '') {
        const text = 'Please fill all the fields'
        swal.fire({
          text,
          type: 'error',
          title: 'Enter Message',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return false
      }
      const res = {
        message: this.supportMessage,
      }
      const payload = {
        ticketId: this.$route.params.id,
        status: this.ticketStatus,
        message: res,
      }
      try {
        await this.updateAdminTicketDetails(payload)
        await this.getAdminTicketDetails(payload.ticketId)
        this.supportMessage = this.ticketStatus = ''
      } catch (e) {}
    },
    ticketUpdate() {
      if (this.getAdminSupportTicketDetails.status.id !== 'closed') {
        this.updateTicket()
      }
    },
  },
}
</script>

<style></style>
