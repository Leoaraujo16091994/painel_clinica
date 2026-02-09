<template>
  <div class="painel-root">
    <!-- TOPO -->
    <header class="painel-header">
      <div class="logo">CENEC - Centro de Nefrologia de Caucaia</div>

      <div class="data-hora">
        <div class="data">{{ dataAtual }}</div>
        <div class="hora">{{ horaAtual }}</div>
      </div>
    </header>

    <!-- GRID DE SALAS -->
    <div class="salas-grid">
      <div
        v-for="sala in salas"
        :key="sala.numero"
        class="sala-card"
        :class="{ piscar: sala.atualizado }"
      >
        <div class="sala-numero">
          SALA {{ sala.numero }}
        </div>

        <div class="sala-nome">
          {{ sala.nome || '—' }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

/* ===============================
   ESTADO
================================ */
const filaChamadas = ref([])
const falando = ref(false)

const salas = ref([
  { numero: 1, nome: '', atualizado: false },
  { numero: 2, nome: '', atualizado: false },
  { numero: 3, nome: '', atualizado: false },
  { numero: 4, nome: '', atualizado: false },
  { numero: 5, nome: '', atualizado: false },
  { numero: 6, nome: '', atualizado: false },
  { numero: 7, nome: '', atualizado: false },
  { numero: 8, nome: '', atualizado: false },
  { numero: 9, nome: '', atualizado: false },
  { numero: 10, nome: '', atualizado: false },
  { numero: 11, nome: '', atualizado: false },
  { numero: 12, nome: '', atualizado: false },
])

/* ===============================
   DATA / HORA
================================ */
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

/* ===============================
   FILA / VOZ
================================ */
function processarFila() {
  if (falando.value) return
  if (filaChamadas.value.length === 0) return

  falando.value = true
  const paciente = filaChamadas.value.shift()

  atualizarSala(paciente)
  falarPaciente(paciente)
}

async function falarPaciente(paciente) {
  const texto = `Paciente ${paciente.nome}. Por favor, dirigir-se à sala ${paciente.sala}.`

  const msg = new SpeechSynthesisUtterance(texto)
  msg.lang = 'pt-BR'
  msg.rate = 0.85
  msg.pitch = 1.05
  msg.volume = 1

  const voices = await carregarVozes()

  const vozGoogle =
    voices.find(v => v.lang === 'pt-BR' && v.name.toLowerCase().includes('google')) ||
    voices.find(v => v.lang === 'pt-BR')

  if (vozGoogle) msg.voice = vozGoogle

  msg.onend = () => {
    falando.value = false
    processarFila()
  }

  speechSynthesis.speak(msg)
}

/* ===============================
   ATUALIZA SALA + PISCAR
================================ */
function atualizarSala(paciente) {
  const sala = salas.value.find(s => s.numero === paciente.sala)
  if (!sala) return

  sala.nome = paciente.nome
  sala.atualizado = true

  setTimeout(() => {
    sala.atualizado = false
  }, 1200)
}

/* ===============================
   VOZES
================================ */
function carregarVozes() {
  return new Promise(resolve => {
    const voices = speechSynthesis.getVoices()
    if (voices.length) {
      resolve(voices)
    } else {
      speechSynthesis.onvoiceschanged = () => {
        resolve(speechSynthesis.getVoices())
      }
    }
  })
}

/* ===============================
   ECHO
================================ */
onMounted(() => {
  atualizarRelogio()
  setInterval(atualizarRelogio, 1000)

  window.Echo
    .channel('chamadas')
    .listen('.PacienteChamado', (e) => {
      console.log('EVENTO RECEBIDO', e)
      filaChamadas.value.push(e.paciente)
      processarFila()
    })
})
</script>

<style scoped>
/* ROOT */
.painel-root {
  width: 100vw;
  height: 100vh;
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

.data,
.hora {
  font-size: 20px;
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
  transition: background-color 0.3s;
}

.sala-numero {
  font-size: 37px;
  opacity: 0.8;
  /* margin-bottom: 10px; */
  text-align: center;
}

.sala-nome {
  font-size: 43px;
  font-weight: bold;
  text-align: center;
}

/* ===============================
   PISCAR DISCRETO
================================ */
.piscar {
  animation: piscarVerde 0.6s ease-in-out 2;
}

@keyframes piscarVerde {
  0% {
    background-color: #132f4c;
  }
  50% {
    background-color: #1b5e20;
  }
  100% {
    background-color: #132f4c;
  }
}
</style>
