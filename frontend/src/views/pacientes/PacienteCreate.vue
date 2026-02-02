<template>
  <div>
    <h1>Criar Paciente</h1>
    <router-link to="/">Voltar ao Home</router-link>
    <!-- <form @submit.prevent="criarPaciente" style="margin-top:10px;">
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
      <button type="submit" style="margin-top:5px;">Criar</button>
    </form> -->
  </div>
</template>

<!-- <script>
import axios from 'axios'

export default {
  data() {
    return {
      nome: '',
      email: '',
      telefone: ''
    }
  },
  methods: {
    criarPaciente() {
      axios.post('http://localhost:8000/api/pacientes', {
        nome: this.nome,
        email: this.email,
        telefone: this.telefone
      }).then(() => this.$router.push('/pacientes'))
      .catch(err => alert('Erro: ' + err.response.data.message))
    }
  }
}
</script> -->
