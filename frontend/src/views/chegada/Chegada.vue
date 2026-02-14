<template>
  <v-snackbar v-model="snackbar.show" :color="snackbar.color" location="top" timeout="3000">
    {{ snackbar.text }}
  </v-snackbar>

  <v-card>
    <v-card-title class="d-flex align-center justify-space-between">
      <span>Chegada de Pacientes (Hoje)</span>

      <div class="d-flex align-center">
        <v-text-field v-model="filtroNome" label="Pesquisar por nome" density="compact" prepend-inner-icon="mdi-magnify" class="mr-3" hide-details style="width: 300px" />

        <v-btn color="primary" prepend-icon="mdi-plus" @click="abrirCadastroExtra">
          Paciente Extra
        </v-btn>
      </div>
    </v-card-title>

    <v-divider />

    <v-data-table :headers="headers" :items="pacientesFiltrados" item-key="id">
      <template #item.nome="{ item }">
        {{ item.paciente?.nome_completo || 'Paciente Extra' }}
      </template>

      <template #item.chegou="{ item }">
        <v-chip :color="item.chegou ? 'success' : 'grey'">
          {{ item.chegou ? 'Chegou' : 'Não chegou' }}
        </v-chip>
      </template>

      <template #item.sala_dia="{ item }">
        {{ salasMap[item.sala_dia] || '-' }}
      </template>

      <template #item.acoes="{ item }">
        <v-btn color="success" variant="text" icon="mdi-check" :disabled="item.chegou" @click="abrirConfirmarChegada(item)" />
        <v-btn color="primary" variant="text" icon="mdi-swap-horizontal" @click="abrirTrocaSala(item)" />
      </template>
    </v-data-table>
  </v-card>

  <PacienteExtra v-model="modalPacienteExtra" @salvo="onPacienteSalvo" />

  <!-- MODAL TROCA DE SALA (REUTILIZÁVEL) -->
  <ModalTrocaSala
    v-model="modalTrocaSala"
    :paciente="pacienteSelecionado"
    :salas="salas"
    @confirmar="trocarSala"
  />

  <!-- MODAL CONFIRMAR CHEGADA -->
  <v-dialog v-model="modalConfirmaChegada" max-width="420">
    <v-card>
      <v-card-title class="text-h6 bg-primary text-white">
        Confirmar chegada
      </v-card-title>

      <v-card-text>
        Tem certeza que deseja confirmar chegada do paciente
        <strong>{{ pacienteSelecionado?.paciente.nome_completo }}</strong>?
      </v-card-text>

      <v-card-actions class="justify-end">
        <v-btn color="red" variant="elevated" @click="modalConfirmaChegada = false">
          Cancelar
        </v-btn>

        <v-btn color="green" variant="elevated" @click="confirmarChegada(pacienteSelecionado)">
          Confirmar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, computed, onMounted, inject } from 'vue'
import PacienteDiaService from '@/services/PacienteDiaService'
import PacienteExtra from '@/views/pacientes/PacienteExtra.vue'
import ModalTrocaSala from '../components/ModalTrocaSala.vue'

const snackbar = inject('snackbar')

const pacientes = ref([])
const filtroNome = ref('')
const modalPacienteExtra = ref(false)
const modalTrocaSala = ref(false)
const modalConfirmaChegada = ref(false)
const pacienteSelecionado = ref(null)

const salas = [
  { title: 'Sala 01', value: 1 },
  { title: 'Sala 02', value: 2 },
  { title: 'Sala 03', value: 3 },
  { title: 'Sala 04', value: 4 },
  { title: 'Sala 05', value: 5 },
  { title: 'Sala 06', value: 6 },
  { title: 'Sala 07', value: 7 },
  { title: 'Sala 08', value: 8 },
  { title: 'Sala 09', value: 9 },
  { title: 'Sala 10', value: 10 },
  { title: 'Sala 11', value: 11 },
  { title: 'Sala C', value: 12 },
]

const salasMap = Object.fromEntries(salas.map(s => [s.value, s.title]))

const headers = [
  { title: 'Paciente', key: 'nome' },
  { title: 'Chegou', key: 'chegou' },
  { title: 'Sala do dia', key: 'sala_dia' },
  { title: 'Ações', key: 'acoes', sortable: false },
]

const pacientesFiltrados = computed(() => {
  if (!filtroNome.value) return pacientes.value
  return pacientes.value.filter(p =>
    p.paciente?.nome_completo?.toLowerCase().includes(filtroNome.value.toLowerCase())
  )
})

function carregarPacientes() {
  PacienteDiaService.listar().then(res => {
    pacientes.value = res.data
  })
}

function abrirTrocaSala(paciente) {
  pacienteSelecionado.value = paciente
  modalTrocaSala.value = true
}

function trocarSala(novaSala) {
  PacienteDiaService.trocarSala(pacienteSelecionado.value.id, novaSala)
    .then(() => {
      pacienteSelecionado.value.sala_dia = novaSala

      snackbar.value.text = "Troca de sala confirmada"
      snackbar.value.color = "success"
      snackbar.value.show = true
    })
}

function abrirCadastroExtra() {
  modalPacienteExtra.value = true
}

function abrirConfirmarChegada(paciente) {
  pacienteSelecionado.value = paciente
  modalConfirmaChegada.value = true
}

function confirmarChegada(paciente) {
  PacienteDiaService.confirmarChegada(paciente.id).then(() => {
    paciente.chegou = true

    snackbar.value.text = "Chegada confirmada"
    snackbar.value.color = "success"
    snackbar.value.show = true

    modalConfirmaChegada.value = false
  })
}

function onPacienteSalvo() {
  carregarPacientes()
}

onMounted(carregarPacientes)
</script>
