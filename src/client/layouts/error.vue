<template>
  <div class="container mx-auto py-4 px-4 mt-20 h-full bg-black">
    <div class="flex flex-col text-center">
      <div class="mb-8">
        <h1
          v-if="error.statusCode === 404"
          class="text-1xl md:text-2xl lg:text-4xl text-white"
        >
          Page not found
        </h1>
        <h1 v-else class="text-1xl md:text-2xl lg:text-4xl text-white">
          {{ error.message }}
        </h1>
        <h3 class="text-1xl md:text-2xl lg:text-4xl text-white">
          {{ error.statusCode }}
        </h3>
      </div>
      <div
        class="
          block
          bg-gold
          hover:bg-brand
          text-brand
          hover:text-red
          font-bold
          py-2
          px-4
          rounded
          max-w-xs
          mx-auto
          focus:outline-none focus:shadow-outline
          cursor-pointer
        "
      >
        <nuxt-link to="/login">Go back to login</nuxt-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ErrorLayout',
  props: ['error', 'message'],
  layout: 'claim',
}
</script>
