<template>
  <div>
    <base-table
      :table-title="widgetTitle"
      :header-items="headerItems"
      :records="allgames"
      text-color="text-white"
      @on-row-click="(record) => $emit('row-clicked', record)"
    >
      <template slot="status" slot-scope="{ item }">
        <div>{{ item.status.name }}</div>
      </template>
      <template slot="is_extended" slot-scope="{ item }">
        <div v-if="item.is_extended">Yes</div>
        <div v-else>No</div>
      </template>
      <template slot="map" slot-scope="{ item }">
        <div>Map {{ item.map.id }}</div>
      </template>
      <template slot="no-items"> Nothing Found </template>
    </base-table>
  </div>
</template>

<script>
export default {
  name: 'AllGamesWidget',
  props: {
    widgetTitle: {
      type: String,
      default: 'Current Active Games',
    },
    allgames: {
      type: Array,
      default: () => [],
    },
  },
  data: () => ({
    headerItems: [
      {
        id: 'name',
        name: 'Name',
      },
      {
        id: 'jackpot_value',
        name: 'Jackpot',
      },
      {
        id: 'entry_fee',
        name: 'Entry Fee',
      },
      {
        id: 'admin_earning',
        name: 'Earnings',
      },
      {
        id: 'days_remaining',
        name: 'Days left',
      },
      {
        id: 'is_extended',
        name: 'Extended Mode',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'map',
        name: 'Map',
      },
    ],
  }),
  methods: {
    updateGame(payload) {
      console.log(payload)
    },
  },
}
</script>

<style></style>
