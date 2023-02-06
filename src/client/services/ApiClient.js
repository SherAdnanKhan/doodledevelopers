let client

export function setClient(newclient) {
  client = newclient
}

// Request helpers
const reqMethods = ['get', 'post', 'put', 'delete', 'patch']

const service = {}

reqMethods.forEach((method) => {
  service[method] = function () {
    if (!client) throw new Error('apiClient not installed')
    return client[method].apply(null, arguments)
  }
})

export default service
