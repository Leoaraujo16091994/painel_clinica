import axios from 'axios'
import api from '../api' // importa o Axios do arquivo api.js


// Funções para cada operação do CRUD
export default {
  listar() {
    return api.get('/paciente')
  },

  buscar(id) {
    return api.get(`/paciente/${id}`)
  },

  criar(paciente) {
    return api.post('/paciente', paciente)
  },

  atualizar(id, paciente) {
    return api.put(`/paciente/${id}`, paciente)
  },

  deletar(id) {
    return api.delete(`/paciente/${id}`)
  }
}
