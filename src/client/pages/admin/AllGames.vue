<template>
  <div>
    <button
      class="
        py-4
        rounded
        mb-2
        mt-5
        text-lg text-white
        bg-green-700
        focus:outline-none
        w-full
      "
      type="button"
      @click="toggleModal()"
    >
      + {{ $t('create_new_game') }}
    </button>
    <div class="grid grid-cols-1">
      <base-modal :showing="modalVisible" @close="modalVisible = false">
        <template slot="title">
          <h1 class="text-white text-2xl mb-4">
            {{ $t('create_new_game') }}
          </h1>
        </template>
        <template slot="content">
          <create-game-form @game-created="getAllGames" />
        </template>
      </base-modal>
      <all-games-widget
        widget-title="All Games"
        :allgames="adminAllGames"
        @row-clicked="getGameDetails"
      >
      </all-games-widget>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2'
import { mapGetters } from 'vuex'
import AllGamesWidget from '~/components/Admin/AllGamesWidget.vue'
import CreateGameForm from '~/components/Admin/CreateGameForm.vue'
import BaseModal from '~/components/Shared/BaseModal.vue'
export default {
  name: 'AllGames',
  components: {
    AllGamesWidget,
    CreateGameForm,
    BaseModal,
  },
  layout: 'Admin',
  async asyncData({ store }) {
    await store.dispatch('AdminMapStore/getAdminMaps')
    await store.dispatch('AdminGameStore/getAdminGames')
  },
  data: () => ({
    modalVisible: false,
  }),
  mounted() {
    window.addEventListener('keyup', this.escEvent)
  },
  computed: {
    ...mapGetters('AdminGameStore', ['adminAllGames']),
  },
  destroyed() {
    window.removeEventListener('keyup', this.escEvent)
  },
  methods: {
    getGameDetails(payload) {
      this.$router.push({ name: 'game-details', params: { id: payload.id } })
    },
    toggleModal() {
      this.modalVisible = true
    },
    async getAllGames() {
      await this.$store.dispatch('AdminGameStore/getAdminGames')
      this.modalVisible = false
      this.gameCreateMessage()
    },
    gameCreateMessage() {
      const text = 'Game Created Successfully'
      swal.fire({
        text,
        type: 'success',
        title: 'Game Created',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
      })
    },
    escEvent(e) {
      if (e.key === 'Escape' && this.modalVisible === true) {
        this.modalVisible = false
      }
    },
  },
}
</script>

<style></style>
