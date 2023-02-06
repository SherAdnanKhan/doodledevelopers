<template>
  <div class="rounded p-8 mr-5" :class="backgroundColor">
    <h1 class="text-2xl mb-4 text-center" :class="foreGroundColor">
      {{ title }}
    </h1>
    <h6
      v-for="(item, index) in items"
      :key="index"
      class="text-lg mr-4"
      :class="foreGroundColor"
    >
      <span class="text-right">{{ item.name }}</span>
    </h6>
  </div>
</template>

<script>
export default {
  name: 'HistoryCard',
  props: {
    title: {
      type: String,
      required: true,
    },
    items: {
      type: Array,
      required: true,
    },
    backgroundColor: {
      type: String,
      default: 'bg-white',
    },
    foreGroundColor: {
      type: String,
      default: 'text-white',
    },
  },
}
</script>
