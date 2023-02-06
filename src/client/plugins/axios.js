import swal from 'sweetalert2'
import Cookies from 'js-cookie'

process.env.NODE_TLS_REJECT_UNAUTHORIZED = '1'

export default ({ app, store, redirect, $axios }) => {
  $axios.setBaseURL(process.env.apiUrl)
  if (process.server) {
    return
  }
  $axios.onRequest((request) => {
    const token = store.getters['auth/token'] || Cookies.get('token')

    if (token) {
      $axios.setHeader('Authorization', `Bearer ${token}`)
      request.headers.common.Authorization = `Bearer ${token}`
    }

    const locale = store.getters['lang/locale']
    if (locale) {
      request.headers.common['Accept-Language'] = locale
    }

    return request
  })

  // Response interceptor
  $axios.onError((error) => {
    const status = parseInt(error.response && error.response.status)

    if (status >= 500) {
      swal.fire({
        type: 'error',
        title: app.i18n.t('error_alert_title'),
        text: app.i18n.t('error_alert_text'),
        reverseButtons: true,
        confirmButtonText: app.i18n.t('ok'),
        cancelButtonText: app.i18n.t('cancel'),
      })
    }

    if (status === 401 && store.getters['auth/isAuthenticated']) {
      swal
        .fire({
          type: 'warning',
          title: app.i18n.t('token_expired_alert_title'),
          text: app.i18n.t('token_expired_alert_text'),
          reverseButtons: true,
          confirmButtonText: app.i18n.t('ok'),
          cancelButtonText: app.i18n.t('cancel'),
        })
        .then(() => {
          store.commit('auth/LOGOUT')

          redirect({ name: 'login' })
        })
    }

    return Promise.reject(error)
  })
}
