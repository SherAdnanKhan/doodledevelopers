<template>
  <div class="container lg:px-8 mx-auto rounded-lg">
    <div class="card-header bg-gold p-4 font-bold">
      <div class="flex">
        <div class="text-3xl text-black">
          {{ getUserSupportTicketDetails.title.toUpperCase() }}
        </div>
      </div>
      <div class="flex">
        <div class="text-md text-black">
          {{ getUserSupportTicketDetails.description }}
        </div>
      </div>
    </div>
    <div class="p-4 items-center">
      <template
        v-if="
          getUserSupportTicketDetails.messages &&
          getUserSupportTicketDetails.messages.length
        "
      >
        <TicketDetails :user-message="getUserSupportTicketDetails.messages" />
      </template>
      <div v-else>
        <h1 class="text-gold text-center text-xl py-16">
          This is the start of your conversation <br />
          Type a message to follow up
        </h1>
      </div>
    </div>
    <div class="bg-white p-4 items-center flex justify-between">
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
          focus:border-gray-400
          ml-6
        "
      />
      <button
        :disabled="getUserSupportTicketDetails.status.id === 'closed'"
        class="rounded-full bg-ggold font-bold border-2 text-white w-1/6 p-3"
        :class="
          getUserSupportTicketDetails.status.id === 'closed'
            ? 'cursor-not-allowed '
            : 'bg-gold border-gold'
        "
        @click="sendMessage"
      >
        Submit
      </button>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import swal from 'sweetalert2'
import TicketDetails from '~/components/User/TicketDetails.vue'
export default {
  name: 'UserTicketDetails',
  layout: 'User',
  components: { TicketDetails },
  async asyncData({ store, route }) {
    await store.dispatch(
      'UserSupportStore/getUserTicketDetails',
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
  }),
  computed: {
    ...mapGetters('UserSupportStore', [
      'getUserSupportTicketDetails',
      'sendSupportUserMessage',
    ]),
  },
  methods: {
    ...mapActions('UserSupportStore', [
      'sendSupportMessage',
      'getUserTicketDetails',
    ]),
    async sendMessage() {
      if (this.supportMessage === '') {
        const text = 'Please Enter Message First'
        swal.fire({
          text,
          type: 'error',
          title: 'Enter Message',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        return false
      }
      const payload = {
        ticket_id: this.$route.params.id,
        message: this.supportMessage,
      }
      try {
        await this.sendSupportMessage(payload)
        await this.getUserTicketDetails(payload.ticket_id)
        this.supportMessage = ''
      } catch (e) {}
    },
  },
}
</script>

<style></style>
