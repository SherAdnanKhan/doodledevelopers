<template>
  <div>
    <base-table
      table-title="Select any game to see the payouts"
      :header-items="headerItems"
      :records="userAllPlayedGames"
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
      <template slot="actions" slot-scope="{ item }">
        <div>
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
            Select
          </button>
        </div>
      </template>
      <template slot="no-items"> Nothing Found </template>
    </base-table>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'UserPayouts',
  layout: 'User',
  async asyncData({ store, route }) {
    await store.dispatch('UserGameStore/getUserPlayedGames')
  },
  data: () => ({
    headerItems: [
      {
        id: 'name',
        name: 'Name',
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
  }),
  computed: {
    ...mapGetters('UserGameStore', ['userAllPlayedGames']),
  },
  methods: {
    showDetails(payload) {
      this.$router.push({
        name: 'user-payouts-details',
        params: { id: payload.id },
      })
    },
  },
}
</script>
