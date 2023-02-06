<template>
  <base-table
    :table-title="tableTitle"
    :header-items="headerItems"
    :records="earnings"
    text-color="text-white"
  >
    <template slot="game" slot-scope="{ item }">
      <div>{{ item.game.name }}</div>
    </template>
    <template slot="earning" slot-scope="{ item }">
      <div>
        <img
          class="w-6 h-6 inline-block mr-2"
          src="~/assets/images/icon.png"
          alt=""
        />
        {{ item.earning }}
      </div>
    </template>
    <template slot="created_at" slot-scope="{ item }">
      <div>
        {{ $moment(new Date(item.created_at)).format('DD/MM/YYYY HH:mm:ss') }}
      </div>
    </template>
    <template slot="no-items"> Nothing Found </template>
  </base-table>
</template>

<script>
export default {
  name: 'UserEarningsWidget',
  props: {
    tableTitle: {
      type: String,
      default: 'Earnings',
    },
    earnings: {
      type: Array,
      default: () => [],
    },
  },
  data: () => ({
    headerItems: [
      {
        id: 'game',
        name: 'Game',
      },
      {
        id: 'earning',
        name: 'Amount',
      },
      {
        id: 'created_at',
        name: 'Earned At',
      },
    ],
  }),
}
</script>
