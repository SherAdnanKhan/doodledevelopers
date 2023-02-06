import { setClient } from '~/services/ApiClient'

export default ({ app }) => {
  setClient(app.$axios)
}
