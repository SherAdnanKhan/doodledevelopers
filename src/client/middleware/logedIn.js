export default ({ store, route, redirect }) => {
  if (route.name === 'welcome' && store.getters['auth/isAuthenticated']) {
    return redirect('/live-games')
  }
}
