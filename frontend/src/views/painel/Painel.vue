<template>
    <v-app>
  <!-- TELA CHEIA -->
  <div class="painel-root">
    <!-- TOPO -->
    <!-- <header class="painel-header">
      <div class="logo">Clínica Bem-Estar</div>

      <div class="data-hora">
        <div class="data">{{ dataAtual }}</div>
        <div class="hora">{{ horaAtual }}</div>
      </div>
    </header> -->

    <!-- GRID DE SALAS -->
    <div class="salas-grid">
      <div
        v-for="sala in salas"
        :key="sala.numero"
        class="sala-card"
      >
        <div class="sala-numero">
          SALA {{ sala.numero }}
        </div>

        <div class="sala-nome">
          {{ sala.nome }}
        </div>
      </div>
    </div>
  </div>
  </v-app>
</template>

<script setup>
import { ref, onMounted } from 'vue'

/* DATA E HORA */
const dataAtual = ref('')
const horaAtual = ref('')

function atualizarRelogio() {
  const agora = new Date()

  dataAtual.value = agora.toLocaleDateString('pt-BR', {
    weekday: 'long',
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  })

  horaAtual.value = agora.toLocaleTimeString('pt-BR')
}

// onMounted(() => {
//   atualizarRelogio()
//   setInterval(atualizarRelogio, 1000)
// })

/* SALAS */
const salas = ref([
  { numero: 1, nome: 'Leonardo Amancio de Araujo' },
  { numero: 2, nome: 'Ingryd Rocha de Araujo' },
  { numero: 3, nome: 'Olivia Rocha de Araujo' },
  { numero: 4, nome: 'Carlos Oliveira' },
  { numero: 5, nome: 'Ana Paula Santos' },
  { numero: 6, nome: 'Rafael Gomes teste nome completo' },
  { numero: 7, nome: 'Maria Souza' },
  { numero: 8, nome: 'Pedro Almeida' },
  { numero: 9, nome: 'Juliana Pereira' },
  { numero: 10, nome: 'João Silva' },
  { numero: 11, nome: 'Patricia Rocha' },
  { numero: 12, nome: 'Gumila Fernandes nome completo aqui' },
])
</script>

<style scoped>
/* ROOT */
.painel-root {
  width: 80vw;
  height: 80vh;
  background: linear-gradient(180deg, #071a2d, #020c17);
  color: white;
  display: flex;
  flex-direction: column;
}

/* HEADER */
.painel-header {
  height: 90px;
  padding: 0 32px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #0d47a1;
}

.logo {
  font-size: 22px;
  font-weight: bold;
}

.data-hora {
  text-align: right;
}

.data {
  font-size: 20px;
  opacity: 0.9;
}

.hora {
  font-size: 20px;
  font-weight: bold;
}

/* GRID */
.salas-grid {
  flex: 1;
  padding: 32px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}

/* CARD */
.sala-card {
  background: #132f4c;
  border-radius: 14px;
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  
}

.sala-numero {
  font-size: 20px;
  opacity: 0.8;
  margin-bottom: 10px;
  align-items: center;  
  text-align: center;  
}

.sala-nome {
  font-size: 35px;
  font-weight: bold;
  line-height: 1.3;
}
</style>
