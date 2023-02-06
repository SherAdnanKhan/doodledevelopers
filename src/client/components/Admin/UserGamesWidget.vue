<template>
  <base-table
    :table-title="tableTitle"
    :header-items="headerItems"
    :records="games"
    text-color="text-white"
  >
    <template slot="name" slot-scope="{ item }">
      <div>{{ item.name }}</div>
    </template>
    <template slot="number_of_times_played" slot-scope="{ item }">
      <div>{{ item.pivot.number_of_times_played }}</div>
    </template>
    <template slot="highest_score" slot-scope="{ item }">
      <div>{{ item.pivot.highest_score }}</div>
    </template>
    <template slot="shortest_duration" slot-scope="{ item }">
      <div>{{ item.pivot.shortest_duration }}</div>
    </template>
    <template slot="status" slot-scope="{ item }">
      <div>{{ item.pivot.status }}</div>
    </template>
    <template slot="last_played_at" slot-scope="{ item }">
      <div>
        {{
          $moment(new Date(item.pivot.updated_at)).format('DD/MM/YYYY HH:mm:ss')
        }}
      </div>
    </template>
    <template slot="no-items"> Nothing Found </template>
  </base-table>
</template>

<script>
export default {
  name: 'UserGamesWidget',
  props: {
    tableTitle: {
      type: String,
      default: 'Games',
    },
    games: {
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
        id: 'number_of_times_played',
        name: 'Times Played',
      },
      {
        id: 'highest_score',
        name: 'Highest Score',
      },
      {
        id: 'shortest_duration',
        name: 'Shortest Duration',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'last_played_at',
        name: 'Last played at',
      },
    ],
  }),
}
</script>
