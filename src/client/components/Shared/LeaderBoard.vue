<template>
  <div>
    <base-table
      v-for="(game, pos) in games"
      :key="pos"
      :table-title="game.gameName"
      :header-items="headerItems"
      :records="game.players"
      :text-color="textColor"
      :paginate="true"
      class="mb-2"
    >
      <template slot="position" slot-scope="{ index }">
        <div>{{ index + 1 }}</div>
      </template>
      <template slot="name" slot-scope="{ item }">
        <div class="flex flex-row items-center">
          <div>
            <div
              class="image rounded-full"
              :style="{
                backgroundImage:
                  'url(' + profileImage(item.user.profile_image) + ')',
              }"
            ></div>
          </div>
          <span class="username">{{ item.user.username }}</span>
        </div>
      </template>
      <template slot="no-items"> No Leader board Found </template>
    </base-table>
  </div>
</template>

<script>
export default {
  name: 'LeaderBoard',
  props: {
    games: {
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
        id: 'position',
        name: 'Pos',
      },
      {
        id: 'name',
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
.username {
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
::v-deep .respnosive-table {
  overflow-x: hidden;
}
</style>
