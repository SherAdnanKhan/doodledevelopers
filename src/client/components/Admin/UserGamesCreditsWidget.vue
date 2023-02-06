<template>
  <base-table
    :table-title="tableTitle"
    :header-items="headerItems"
    :records="gamewallets"
    text-color="text-white"
  >
    <template slot="game" slot-scope="{ item }">
      <div>{{ item.game.name }}</div>
    </template>
    <template slot="credits" slot-scope="{ item }">
      <div>{{ item.credit }}</div>
    </template>
    <template slot="no-items"> Nothing Found </template>
  </base-table>
</template>

<script>
export default {
  name: 'UserGamesCreditsWidget',
  props: {
    tableTitle: {
      type: String,
      default: 'Game Wallets',
    },
    gamewallets: {
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
        id: 'credits',
        name: 'Credits',
      },
    ],
  }),
}
</script>
