<template>
  <base-table
    :table-title="tableTitle"
    :header-items="headerItems"
    :records="users"
    text-color="text-white"
    @on-row-click="(record) => $emit('row-clicked', record)"
  >
    <template slot="name" slot-scope="{ item }">
      <span>{{ item.first_name + ' ' + item.last_name }}</span>
    </template>
    <template slot="country" slot-scope="{ item }">
      <div>{{ item.country.name }}</div>
    </template>
    <template slot="status" slot-scope="{ item }">
      <div>{{ item.status.name }}</div>
    </template>
    <template slot="action" slot-scope="{ item }">
      <div>
        <button
          type="button"
          class="
            h-8
            m-2
            text-sm
            bg-red bg-opacity-75
            text-gray-200
            rounded
            px-4
            py-2
            focus:outline-none
          "
          :class="{
            'transition-colors duration-150 hover:bg-opacity-100':
              item.status.id === 'active',
          }"
          @click="updateUser(item)"
        >
          {{ item.status.id === 'disabled' ? 'Enable' : 'Disable' }}
        </button>
      </div>
    </template>
    <template slot="no-items"> Nothing Found </template>
  </base-table>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: 'AllUsersWidget',
  props: {
    tableTitle: {
      type: String,
      default: 'All Users',
    },
    users: {
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
        id: 'country',
        name: 'Country',
      },
      {
        id: 'email',
        name: 'Email',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'action',
        name: 'Action',
      },
    ],
  }),
  methods: {
    ...mapActions('AdminUsersStore', ['updateUserAccount', 'getAllUsers']),
    async updateUser(payload) {
      await this.updateUserAccount({
        userId: payload.id,
        payload: {
          status: payload.status.id === 'active' ? 'disabled' : 'active',
        },
      })
      await this.getAllUsers()
    },
  },
}
</script>

<style></style>
