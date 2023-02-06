<template>
  <div>
    <div v-if="Object.keys(currentUserDetails).length">
      <div class="flex mt-4">
        <div
          class="
            w-full
            card
            w-full
            bg-white
            p-0
            rounded
            bg-opacity-75
            shadow-lg
          "
        >
          <div
            class="
              card-header
              bg-green-600
              p-4
              text-xl
              font-bold
              flex
              items-center
              border-b-4 border-gold
            "
          >
            <img
              :src="profileImage"
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
              <span class="uppercase text-white">{{
                currentUserDetails.first_name +
                ' ' +
                currentUserDetails.last_name
              }}</span>
            </div>
          </div>
          <div class="card-body p-4 grid grid-cols-3 gap-2">
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Email</b>
              <span>{{ currentUserDetails.email }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Username</b>
              <span>{{ currentUserDetails.username }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Phone number</b>
              <span>{{ currentUserDetails.phone }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Address 1</b>
              <span>{{ currentUserDetails.address }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500">Address 2</b>
              <span>{{ currentUserDetails.address2 }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Address 3</b>
              <span>{{ currentUserDetails.address3 }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Country</b>
              <span>{{ currentUserDetails.country.name }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">City</b>
              <span>{{ currentUserDetails.city }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">County</b>
              <span>{{ currentUserDetails.county }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Postcode</b>
              <span>{{ currentUserDetails.postcode }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Date of birth</b>
              <span>{{ currentUserDetails.dob }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Kyc verified</b>
              <span>{{
                currentUserDetails.is_kyc_verified == 1 ? 'Yes' : 'No'
              }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Status</b>
              <span>{{ currentUserDetails.status.name }}</span>
            </div>
            <div class="mb-2 text-grey flex flex-col">
              <b class="text-green-500 mb-1">Balance</b>
              <span
                ><img
                  class="w-6 h-6 inline-block mr-2"
                  src="~/assets/images/icon.png"
                  alt=""
                />{{ currentUserDetails.wallet.balance }}</span
              >
            </div>
          </div>
        </div>
      </div>
      <div>
        <user-deposits-widget
          :deposits="currentUserDetails.deposits"
          table-title="All Deposits"
        />
      </div>
      <div>
        <user-games-widget
          :games="currentUserDetails.games"
          table-title="All Games"
        />
      </div>
      <div>
        <user-games-credits-widget
          :gamewallets="currentUserDetails.gamewallets"
          table-title="All Game Credits"
        />
      </div>
      <div>
        <user-earnings-widget
          :earnings="currentUserDetails.earnings"
          table-title="All Earnings"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import UserDepositsWidget from '~/components/Admin/UserDepositsWidget.vue'
import UserGamesWidget from '~/components/Admin/UserGamesWidget.vue'
import UserGamesCreditsWidget from '~/components/Admin/UserGamesCreditsWidget.vue'
import UserEarningsWidget from '~/components/Admin/UserEarningsWidget.vue'

export default {
  name: 'AdminUserDetails',
  layout: 'Admin',
  components: {
    UserDepositsWidget,
    UserGamesWidget,
    UserGamesCreditsWidget,
    UserEarningsWidget,
  },
  async asyncData({ store, route }) {
    if (route.params.id) {
      await store.dispatch('AdminUsersStore/getUserDetails', route.params.id)
    }
  },
  data: () => ({
    modalVisible: false,
    image: require('~/assets/images/user.png'),
  }),
  computed: {
    ...mapGetters('AdminUsersStore', ['currentUserDetails', 'getErrorMessage']),
    profileImage() {
      console.log(this.currentUserDetails)
      return this.currentUserDetails.profile_image ?? this.image
    },
  },
  methods: {
    ...mapActions('AdminUsersStore', ['getUserDetails']),
  },
}
</script>

<style></style>
