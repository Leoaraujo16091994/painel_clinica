import axios from 'axios'
import api from '../api' 

export default {
    ultimos() {
        return api.get('/painel/ultimos')
    },

    proximo() {
        return api.get('/painel/proximo')
    },

    confirmarChamada(paciente) {
        return api.post(`painel/${id}/confirmar-chamada`, paciente)
    },

    

}
