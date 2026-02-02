<template>
  <div>
    <h1>Editar Paciente</h1>
    <router-link to="/">Voltar ao Home</router-link>
    <!-- <form @submit.prevent="atualizarPaciente" style="margin-top:10px;">
      <div>
        <label>Nome:</label>
        <input v-model="nome" required />
      </div>
      <div>
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label>Telefone:</label>
        <input v-model="telefone" />
      </div>
      <button type="submit" style="margin-top:5px;">Atualizar</button>
    </form> -->
  </div>
</template>

<!-- <script>
import axios from 'axios'

export default {
  props: ['id'],
  data() {
    return { nome: '', email: '', telefone: '' }
  },
  mounted() {
    axios.get(`http://localhost:8000/api/pacientes/${this.id}`)
      .then(res => {
        this.nome = res.data.nome
        this.email = res.data.email
        this.telefone = res.data.telefone
      })
  },
  methods: {
    atualizarPaciente() {
      axios.put(`http://localhost:8000/api/pacientes/${this.id}`, {
        nome: this.nome,
        email: this.email,
        telefone: this.telefone
      }).then(() => this.$router.push('/pacientes'))
      .catch(err => alert('Erro: ' + err.response.data.message))
    }
  }
}
</script> -->
