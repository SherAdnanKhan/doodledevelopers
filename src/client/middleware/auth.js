export default (context) => {
  const { store, redirect } = context
  if (!store.getters['auth/isAuthenticated']) {
    store.commit('auth/LOGOUT')
    return redirect('/login')
  }
}
