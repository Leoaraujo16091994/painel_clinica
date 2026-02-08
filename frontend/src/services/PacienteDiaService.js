import axios from 'axios'
import api from '../api' 

export default {
    listar() {
        return api.get('/paciente-dia')
    },

    criar(paciente) {
        return api.post('/paciente-dia', paciente)
    },

    trocarSala(id, novaSala) {
        return api.put(`/paciente-dia/${id}`, {
            sala_dia: novaSala
        })
    },

    deletar(id) {
        return api.delete(`/paciente-dia/${id}`)
    },

    confirmarChegada(id) {
        return api.put(`/chamada/${id}/chegou`)
    },
    
    confirmarChamada(id) {
        return api.put(`/chamada/${id}/chamar`)
    },

    chamarNovamente(paciente) {
        return api.post(`/chamada/${id}/chamar-novamente`, paciente)
    },

    chamarAcompanhante(paciente) {
        return api.post(`/chamada/${id}/chamar-acompanhante`, paciente)
    },

}
