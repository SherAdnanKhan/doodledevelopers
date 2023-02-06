<template>
  <div>
    <div class="text-center">
      <button
        class="
          card-header
          mb-4
          p-3
          rounded rounded-b-none
          text-2xl text-center text-white
          bg-green-700
          focus:outline-none
          w-2/4
          h-a
        "
        @click="createPayout()"
      >
        + Create New Payout
      </button>
    </div>
    <base-table
      table-title="Select any game to see the payouts"
      :header-items="headerItems"
      :records="getAllUserPayouts"
    >
      <template slot="name" slot-scope="{ item }">
        <div>
          {{ item.name }}
        </div>
      </template>
      <template slot="status" slot-scope="{ item }">
        <div>
          {{ item.status.name }}
        </div>
      </template>
      <template slot="type" slot-scope="{ item }">
        <div>
          {{ item.type.name }}
        </div>
      </template>
      <template slot="created_at" slot-scope="{ item }">
        <div>
          {{ dateChange(item.created_at) }}
        </div>
      </template>
      <template slot="no-items"> Nothing Found </template>
    </base-table>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import swal from 'sweetalert2'
export default {
  name: 'UserPayoutsDetails',
  layout: 'User',
  async asyncData({ store, route }) {
    await store.dispatch('UserPaymentsStore/getUserPayouts', route.params.id)
  },
  data: () => ({
    headerItems: [
      {
        id: 'amount',
        name: 'Amount',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'created_at',
        name: 'Created At',
      },
      {
        id: 'type',
        name: 'Type',
      },
    ],
  }),
  computed: {
    ...mapGetters('UserPaymentsStore', [
      'getAllUserPayouts',
      'errorMessage',
      'createUserPayoutRequest',
    ]),
  },
  methods: {
    ...mapActions('UserPaymentsStore', ['getUserPayouts', 'createUserPayout']),
    dateChange(date) {
      return new date.toLocaleString()
    },
    async createPayout() {
      try {
        await this.createUserPayout(this.$route.params.id)
        const text = 'Payout Request Succssfully Created'
        swal.fire({
          text,
          type: 'success',
          title: 'Successfully Created',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
        })
        await this.getUserPayouts(this.$route.params.id)
      } catch (e) {
        if (this.errorMessage) {
          const text = this.errorMessage
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
  },
}
</script>

<style lang="scss" scoped></style>
