<template>
  <Transition name="fade">
    <div
      v-if="showing"
      class="
        z-50
        fixed
        inset-0
        w-full
        h-screen
        flex
        items-center
        justify-center
        bg-semi-75 bg-black bg-opacity-50
        overflow-scroll
      "
      @click.self="close"
    >
      <div class="relative w-full max-w-2xl bg-grey shadow-lg rounded-lg p-8">
        <div class="flex items-center justify-between w-full mx-auto">
          <slot name="title" />
          <button
            aria-label="close"
            class="text-4xl text-gray-500 outline-none focus:outline-none"
            @click.prevent="close"
          >
            ×
          </button>
        </div>
        <slot name="content" />
      </div>
    </div>
  </Transition>
</template>
<script>
export default {
  props: {
    showing: {
      required: true,
      type: Boolean,
    },
  },
  watch: {
    showing(value) {
      if (value) {
        return document.querySelector('body').classList.add('overflow-hidden')
      }

      document.querySelector('body').classList.remove('overflow-hidden')
    },
  },
  methods: {
    close() {
      this.$emit('close')
    },
  },
}
</script>
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.4s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
