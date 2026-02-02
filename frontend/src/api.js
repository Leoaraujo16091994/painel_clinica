import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost/api', // URL do backend Laravel
  headers: {
    'Content-Type': 'application/json'
  }
})

export default api
