<template>
  <base-table 
    :header-items="headerItems" 
    :records="winners" 
    :text-color="textColor"
  >
    <template slot="gamename" slot-scope="{ item }">
      <div class="flex flex-row items-center">
        <span>{{ item.gameName | stringLimit(10) }}</span>
      </div>
    </template>
    <template slot="username" slot-scope="{ item }">
      <div class="flex flex-row items-center">
        <span>{{ item.winners[0].user.username | stringLimit(10) }}</span>
      </div>
    </template>
    <template slot="highest_score" slot-scope="{ item }">
      <div class="flex flex-row items-center">
        <span>{{ item.winners[0].game_player.highest_score | stringLimit(10) }}</span>
      </div>
    </template>
    <template slot="shortest_duration" slot-scope="{ item }">
      <div class="flex flex-row items-center">
        <span>{{ item.winners[0].game_player.shortest_duration | stringLimit(10) }}</span>
      </div>
    </template>
    <template slot="amount" slot-scope="{ item }">
      <div class="flex flex-row items-center">
        <img
          class="w-6 h-6 inline-block mr-2"
          src="~/assets/images/icon.png"
          alt=""
        />
        <span>{{ item.winners[0].earning | stringLimit(10) }}</span>
      </div>
    </template>
    <template slot="no-items"> No Winners Found </template>
  </base-table>
</template>

<script>
export default {
  name: 'Winners',
  filters: {
    stringLimit(value, size) {
      if (!value) return ''
      value = value.toString()

      if (value.length <= size) {
        return value
      }
      return value.substr(0, size) + '...'
    },
  },
  props: {
    winners: {
      type: Array,
      default: () => [],
    },
    textColor: {
      type: String,
      default: 'text-white',
    },
  },
  data: () => ({
    refreshing: false,
    headerItems: [
      {
        id: 'gamename',
        name: 'Game',
      },
      {
        id: 'username',
        name: 'Username',
      },
      {
        id: 'highest_score',
        name: 'Score',
      },
      {
        id: 'shortest_duration',
        name: 'Time',
      },
      {
        id: 'amount',
        name: 'Amount',
      },
    ],
  }),
  methods: {
    profileImage(img) {
      return img ?? require('~/assets/images/user.png')
    },
    refresh() {
      this.$emit('refresh')
    },
  },
}
</script>

<style lang="scss" scoped>
.image {
  display: block;
  overflow: hidden;
  width: 25px;
  height: 25px;
  background-position: center center;
  background-size: cover;
  background-repeat: no-repeat;
  margin-right: 1rem;
}
</style>
