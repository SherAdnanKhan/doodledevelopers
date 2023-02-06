<template>
  <div class="card p-0 rounded scrolling-auto">
    <div
      v-for="(ticketMessage, index) in userMessage"
      :key="index"
      class="flex justify-end"
    >
      <div
        v-if="ticketMessage.user.is_admin === 1"
        class="m-4 flex justify-end w-3/4"
      >
        <div class="bg-gold rounded-lg px-6 py-4 break-all">
          <span class="text-black text-md">{{ ticketMessage.message }}</span>
        </div>
      </div>
      <div v-else class="m-4 flex justify-start w-full">
        <div class="bg-gray-300 rounded-lg px-6 py-4 break-all">
          <span class="text-black text-md">{{ ticketMessage.message }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TicketDetails',
  props: {
    userMessage: {
      type: Array,
      default: () => [],
    },
  },
}
</script>
