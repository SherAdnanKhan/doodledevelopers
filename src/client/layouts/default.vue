<template>
  <main class="bg-black">
    <Header
      :mobile-menu-visible="mobileMenuVisible"
      @mobileMenuVisibleToggle="mobileMenu"
    />
    <nuxt />
    <Footer v-if="$route.name !== 'game'" class="text-white mt-auto" />
  </main>
</template>

<script>
import { mapGetters } from 'vuex'
import Header from '~/components/Header'
import Footer from '~/components/Footer'

export default {
  name: 'DefaultLayout',
  components: {
    Header,
    Footer,
  },
  data: () => ({
    mobileMenuVisible: false,
    title: process.env.appName,
  }),
  computed: {
    ...mapGetters('auth', ['userName', 'currentUser', 'isAuthenticated']),
  },
  methods: {
    mobileMenu(value) {
      if (value) {
        document.body.classList.remove('js-hamburger--open')
        this.mobileMenuVisible = false
        return
      }
      if (this.mobileMenuVisible) {
        document.body.classList.remove('js-hamburger--open')
        this.mobileMenuVisible = false
      } else {
        document.body.classList.add('js-hamburger--open')
        this.mobileMenuVisible = true
      }
    },
  },
}
</script>
<style lang="scss">
html {
  min-height: 100vh;
  background: black;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

body {
  /* Disables pull-to-refresh but allows overscroll glow effects. */
  overscroll-behavior-y: contain;
  font-family: 'Noto Sans', sans-serif;
  touch-action: pan-x pan-y;
}

input {
  border-radius: 0;
  -webkit-user-select: text; /* Chrome, Opera, Safari */
  -moz-user-select: text; /* Firefox 2+ */
  -ms-user-select: text; /* IE 10+ */
  user-select: text; /* Standard syntax */
}

input:-webkit-autofill,
input:-webkit-autofill:focus {
  -webkit-box-shadow: none;
  box-shadow: none;
}

textarea {
  -webkit-user-select: text;
  user-select: text;
}

h1::-moz-selection,
h2::-moz-selection,
h3::-moz-selection,
h4::-moz-selection,
h5::-moz-selection,
p::-moz-selection,
span::-moz-selection,
input::-moz-selection {
  background: #dbba6b;
  color: #000;
}

h1::-webkit-selection,
h2::-webkit-selection,
h3::-webkit-selection,
h4::-webkit-selection,
h5::-webkit-selection,
p::-webkit-selection,
input::-webkit-selection,
span::-webkit-selection {
  background: #dbba6b;
  color: #000;
}

h1::selection,
h2::selection,
h3::selection,
h4::selection,
h5::selection,
p::selection,
input::selection,
span::selection {
  background: #dbba6b;
  color: #000;
}

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
  -webkit-box-shadow: 0 0 0 60px #fafafa inset !important;
  box-shadow: 0 0 0 60px #fafafa inset !important;
  background-color: transparent !important;
  background-clip: content-box !important;
}

@supports (-webkit-touch-callout: none) {
  /* CSS specific to iOS devices */
}

@supports not (-webkit-touch-callout: none) {
  /* CSS for other than iOS devices */
}

button:focus,
a:focus {
  outline: 0;
}

* {
  -webkit-touch-callout: none;
  user-select: none;
}

a {
  outline: none;
}

td {
  padding-top: 20px;
  padding-bottom: 20px;
  padding-right: 20px;
}

td:first-child {
  padding-left: 10px;
  padding-right: 0;
}

header {
  transition: background-color 350ms ease-in-out;
}

.c-header--active {
  header {
    background-color: #404040;
  }
}

.tp-widget-wrapper {
  text-align: left !important;
}

.game .dg.ac {
  display: none !important;
}

.header-logo {
  flex: 1;
  max-width: 200px;
}

.header-logo {
  max-width: 100px;
}

.game-page {
  .header-logo {
    max-width: 100px;
  }

  header {
    justify-content: center;
  }
}

.card-button {
  z-index: 25;
  border-radius: 12px;

  @media only screen and (max-width: 1024px) {
    position: fixed;
    bottom: 0;
    width: 100%;
    margin-bottom: 0;
    border-radius: 0;
  }
}

.game-card-image {
  min-height: 250px;
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
}

.game-card-body {
  display: flex;
  flex-direction: column;
  background-color: #404040;
}

/* Change the white to any color ;) */
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
  -webkit-box-shadow: 0 0 0 30px black inset !important;
  -webkit-text-fill-color: white !important;
  box-shadow: 0 0 0 30px black inset !important;
}

.btn {
  @apply bg-gold;
  @apply text-black;
  @apply font-bold;
  @apply py-3;
  @apply cursor-pointer;
}

.page-enter-active,
.page-leave-active {
  transition-property: opacity;
  transition-timing-function: ease-in-out;
  transition-duration: 500ms;
}

.page-enter,
.page-leave-to {
  opacity: 0;
}

.layout-enter-active,
.layout-leave-active {
  transition-property: opacity;
  transition-timing-function: ease-in-out;
  transition-duration: 500ms;
}

.layout-enter,
.layout-leave-to {
  opacity: 0;
}

.js-hamburger--open {
  @media only screen and (max-width: 1024px) {
    overflow: hidden;
  }
}

.c-hamburger {
  div {
    position: relative;
    width: 21px;
    height: 10px;
    transform: rotate(0deg);
    transition: 500ms ease-in-out;
    cursor: pointer;
  }

  span {
    display: block;
    position: absolute;
    height: 1px;
    width: 21px;
    background: white;
    border-radius: 9px;
    opacity: 1;
    left: 0;
    transform: rotate(0deg);
    transition: 250ms ease-in-out;
  }

  span:nth-of-type(1) {
    top: 0;
  }

  span:nth-of-type(2),
  span:nth-of-type(3) {
    top: 5px;
  }

  span:nth-of-type(4) {
    top: 10px;
  }

  .js-hamburger--open & {
    span:nth-of-type(1) {
      top: 18px;
      width: 0%;
      left: 50%;
    }

    span:nth-of-type(2) {
      -webkit-transform: rotate(45deg);
      -moz-transform: rotate(45deg);
      -o-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    span:nth-of-type(3) {
      -webkit-transform: rotate(-45deg);
      -moz-transform: rotate(-45deg);
      -o-transform: rotate(-45deg);
      transform: rotate(-45deg);
    }

    span:nth-of-type(4) {
      top: 18px;
      width: 0%;
      left: 50%;
    }
  }
}
</style>
