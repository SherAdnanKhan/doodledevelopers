export default ({ store, redirect }) => {
  if (!store.getters['auth/isAdmin']) {
    return redirect('/')
  }
}
