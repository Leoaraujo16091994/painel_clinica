import axios from 'axios'
import api from '../api' // importa o Axios do arquivo api.js


// Funções para cada operação do CRUD
export default {
  listar() {
    return api.get('/pacientes')
  },

  buscar(id) {
    return api.get(`/pacientes/${id}`)
  },

  criar(paciente) {
    return api.post('/pacientes', paciente)
  },

  atualizar(id, paciente) {
    return api.put(`/pacientes/${id}`, paciente)
  },

  deletar(id) {
    return api.delete(`/pacientes/${id}`)
  }
}
