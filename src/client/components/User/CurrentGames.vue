<template>
  <div class="container mx-auto">
    <base-table
      :table-title="widgetTitle"
      :header-items="headerItems"
      :records="userAllGames"
    >
      <template slot="status" slot-scope="{ item }">
        <div>
          {{ item.status.name }}
        </div>
      </template>
      <template v-if="isAllGames" slot="action" slot-scope="{ item }">
        <button
          class="
            bg-yellow-500
            h-8
            m-2
            text-md
            bg-opacity-75
            text-white
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
      </template>
      <template slot="no-items"> Nothing Found </template>
    </base-table>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'CurrentGames',
  props: {
    widgetTitle: {
      type: String,
      default: 'Current Active Games',
    },
    userAllGames: {
      type: Array,
      default: () => [],
    },
    isAllGames: {
      type: Boolean,
      default: false,
    },
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
        id: 'entry_fee',
        name: 'Entry',
      },
      {
        id: 'start_date',
        name: 'Start date',
      },
      {
        id: 'end_date',
        name: 'End date',
      },
      {
        id: 'days_remaining',
        name: 'Days left',
      },
    ],
  }),
  computed: {
    ...mapGetters('UserGameStore', ['userGameplayHistory']),
  },
  watch: {
    isAllGames: {
      immediate: true,
      handler(value) {
        if (value) {
          this.headerItems.push({ id: 'action', name: 'Action' })
        }
      },
    },
  },
  methods: {
    showDetails(payload) {
      this.$router.push({
        name: 'gameplay-history',
        params: { id: payload.id },
      })
    },
    ...mapActions('UserGameStore', ['getUserGameplayHistory']),
  },
}
</script>
