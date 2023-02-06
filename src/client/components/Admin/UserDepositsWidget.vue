<template>
  <base-table
    :table-title="tableTitle"
    :header-items="headerItems"
    :records="deposits"
    text-color="text-white"
  >
    <template slot="converted_amount" slot-scope="{ item }">
      <span>
        <img
          class="w-6 h-6 inline-block mr-2"
          src="~/assets/images/icon.png"
          alt=""
        />
        {{ item.converted_amount }}
      </span>
    </template>
    <template slot="paymentMethod" slot-scope="{ item }">
      <div>{{ item.paymentMethod.name }}</div>
    </template>
    <template slot="status" slot-scope="{ item }">
      <div>{{ item.status.name }}</div>
    </template>
    <template slot="created_at" slot-scope="{ item }">
      <div>
        {{ $moment(new Date(item.created_at)).format('DD/MM/YYYY HH:mm:ss') }}
      </div>
    </template>
    <template slot="completed_at" slot-scope="{ item }">
      <div>
        {{ $moment(new Date(item.completed_at)).format('DD/MM/YYYY HH:mm:ss') }}
      </div>
    </template>
    <template slot="no-items"> Nothing Found </template>
  </base-table>
</template>

<script>
export default {
  name: 'UserDepositsWidget',
  props: {
    tableTitle: {
      type: String,
      default: 'Deposits',
    },
    deposits: {
      type: Array,
      default: () => [],
    },
  },
  data: () => ({
    headerItems: [
      {
        id: 'converted_amount',
        name: 'Amount',
      },
      {
        id: 'paymentMethod',
        name: 'Payment Method',
      },
      {
        id: 'status',
        name: 'Status',
      },
      {
        id: 'created_at',
        name: 'Requested At',
      },
      {
        id: 'completed_at',
        name: 'Completed At',
      },
    ],
  }),
}
</script>
