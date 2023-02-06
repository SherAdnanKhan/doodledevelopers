module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
  },
  parserOptions: {
    parser: 'babel-eslint',
  },
  extends: [
    '@nuxtjs',
    'prettier',
    'prettier/vue',
    'plugin:prettier/recommended',
    'plugin:nuxt/recommended',
  ],
  plugins: ['prettier'],
  // add your custom rules here
  rules: {
    'vue/max-attributes-per-line': 'off',
    'import/order': 'off',
    'nuxt/no-cjs-in-config': 'off',
    'no-console': 'off',
    'vue/no-v-html': 'off',
    'template-curly-spacing': 'off',
    indent: 'off',
  },
}
