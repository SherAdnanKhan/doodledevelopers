<template>
  <div>
    <div
      v-if="Object.keys(userGameplayHistory).length"
      class="flex mt-4 lg:w-3/4 mx-auto"
    >
      <div
        class="
          card
          w-full
          bg-gray-800
          p-0
          rounded
          cursor-pointer
          bg-opacity-75
          hover:bg-gray-900
          transition
          duration-500
        "
      >
        <div
          class="
            card-header
            rounded
            bg-green-600
            p-4
            text-xl
            font-bold
            flex
            items-center
          "
        >
          <img
            src="https://cdna.artstation.com/p/assets/images/images/023/459/708/large/vaibhav-verma-game-logo.jpg?1579270067"
            width="100"
            height="100"
            class="
              shadow
              rounded-full
              max-w-full
              h-auto
              align-middle
              border-none
            "
          />
          <div class="flex flex-col ml-2">
            <span class="uppercase">{{ userGameplayHistory[0].name }}</span>
          </div>
        </div>
        <base-table
          :table-title="widgetTitle"
          :header-items="headerItems"
          :records="userGameplayHistory"
        >
          <template slot="no-items"> Nothing Found </template>
        </base-table>
      </div>
    </div>
    <div v-else class="flex mt-4 lg:w-3/4 mx-auto">
      <div
        class="
          card
          w-full
          bg-gray-800
          p-0
          rounded
          cursor-pointer
          bg-opacity-75
          hover:bg-gray-900
          transition
          duration-500
        "
      >
        <div
          class="
            card-header
            rounded
            bg-green-600
            p-4
            text-xl
            font-bold
            flex
            items-center
          "
        >
          <h2>Nothing Found</h2>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import BaseTable from '../../components/global/BaseTable.vue'
export default {
  name: 'UserplayHistory',
  scrollToTop: false,
  components: { BaseTable },
  props: {
    widgetTitle: {
      type: String,
      default: 'Game Play History',
    },
  },
  layout: 'User',
  async asyncData({ store, route }) {
    await store.dispatch(
      'UserGameStore/getUserGameplayHistory',
      route.params.id
    )
  },
  data: () => ({
    headerItems: [
      {
        id: 'id',
        name: 'Id',
      },
      {
        id: 'score',
        name: 'Score',
      },
      {
        id: 'duration',
        name: 'Duration',
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
        id: 'status',
        name: 'Status',
      },
    ],
  }),
  computed: {
    ...mapGetters('UserGameStore', ['userGameplayHistory']),
  },
}
</script>

<style></style>
