<template>
  <nav class="py-4">
    <div class="flex items-center flex-col">
      <div class="flex mb-2">
        <liveGamesIcon />
      </div>
      <a class="flex" href="/live-games">Games</a>
    </div>
    <div class="flex items-center flex-col">
      <div class="flex mb-2">
        <liveGamesIcon />
      </div>
      <a class="flex" href="/leaderboard">Leader board</a>
    </div>
    <div class="flex items-center flex-col">
      <div class="flex mb-2">
        <IconTopUp />
      </div>
      <a class="flex" href="/wallet">Wallet</a>
    </div>
    <div class="flex items-center flex-col">
      <div class="flex mb-2">
        <IconProfile />
      </div>
      <a class="flex" href="/account">Account</a>
    </div>
  </nav>
</template>
<script>
import liveGamesIcon from '~/components/svg/IconLiveGames'
import IconTopUp from '~/components/svg/IconTopUp'
import IconProfile from '~/components/svg/IconProfile'

export default {
  components: {
    liveGamesIcon,
    IconTopUp,
    IconProfile,
  },
}
</script>
<style lang="scss" scoped>
nav {
  background: black;
  color: white;
  position: fixed;
  bottom: 0;
  width: 100%;
  z-index: 50;
  display: flex;
  justify-content: space-around;
  align-items: center;
  min-height: 60px;
}
</style>
