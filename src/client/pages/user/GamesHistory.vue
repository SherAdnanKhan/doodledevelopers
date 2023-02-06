<template>
  <div class="container lg:pb-8 px-4 mx-auto max-w-4xl mb-4">
    <h1 class="text-white text-2xl mb-4 text-center mt-4 xl:mb-8">
      Game History
    </h1>
    <div
      v-if="currentEndedGames && currentEndedGames.length"
      class="grid lg:grid-cols-2 gap-6"
    >
      <div
        v-for="(game, index) in currentEndedGames"
        :key="index"
        class="game-card flex flex-col"
      >
        <div
          class="game-card-image"
          :style="{
            backgroundImage: 'url(' + require('~/assets/images/game.png') + ')',
          }"
        />
        <div class="game-card-body p-4 border-red border-t-4 flex-1">
          <h2 class="font-bold text-white text-2xl">{{ game.name }}</h2>
          <span class="flex flex-row items-center mt-2">
            <div class="inline-block mr-2">
              <div class="flex mb-2">
                <span class="text-gold font-semibold mr-2">
                  Position Finished:
                </span>
                <span class="text-white">{{ game.position_finished }}</span>
              </div>
              <div class="flex mb-2">
                <span class="text-gold font-semibold mr-2">Prize Won:</span>
                <span class="text-white">£{{ game.prize_won }}</span>
              </div>
              <div class="flex mb-2">
                <span class="text-gold font-semibold mr-2">Attempts</span>
                <span class="text-white">{{ game.total_attempts }}</span>
              </div>
              <div class="flex mb-2">
                <span class="text-gold font-semibold mr-2">
                  Competition Closed:
                </span>
                <span class="text-white">{{
                  $moment(game.end_date).format('DD/MM/YYYY')
                }}</span>
              </div>
            </div>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'GamesHistory',
  scrollToTop: false,
  layout: 'User',
  async asyncData({ store }) {
    await store.dispatch('UserGameStore/getCurrentEndedGames')
  },
  computed: {
    ...mapGetters({
      currentEndedGames: 'UserGameStore/getCurrentEndedGames',
    }),
  },
  methods: {
    rowClicked(payload) {},
  },
}
</script>

<style></style>
