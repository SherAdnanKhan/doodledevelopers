<template>
  <div class="container lg:px-8 mx-auto">
    <div>
      <base-table
        :header-items="headerItems"
        :records="getAllAdminSupportTickets"
        table-title="All Support Requests"
      >
        <template slot="name" slot-scope="{ item }">
          <div>
            {{ item.user.first_name + ' ' + item.user.last_name }}
          </div>
        </template>
        <template slot="status" slot-scope="{ item }">
          <div>
            {{ item.status.name }}
          </div>
        </template>
        <template slot="description" slot-scope="{ item }">
          <div>
            {{ item.description.substring(0, 70) + '....' }}
          </div>
        </template>
        <template slot="actions" slot-scope="{ item }">
          <div class="flex gap-4">
            <button
              class="
                inline
                bg-yellow-500
                h-8
                m-2
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
          </div>
        </template>
        <template slot="no-items"> Nothing Found </template>
      </base-table>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
// import swal from 'sweetalert2'
export default {
  name: 'AdminSupport',
  layout: 'Admin',
  async asyncData({ store }) {
    await store.dispatch('AdminSupportStore/getAdminSupportTickets')
  },
  data: () => ({
    headerItems: [
      {
        id: 'name',
        name: 'User Name',
      },
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
  computed: {
    ...mapGetters('AdminSupportStore', ['getAllAdminSupportTickets']),
  },
  methods: {
    ...mapActions('AdminSupportStore', ['getAdminSupportTickets']),
    showDetails(payload) {
      this.$router.push({
        name: 'admin-support-details',
        params: { id: payload.id },
      })
    },
  },
}
</script>
