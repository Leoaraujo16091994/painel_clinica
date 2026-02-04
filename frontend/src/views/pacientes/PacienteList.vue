<template>
  <v-snackbar
  v-model="alertSucesso"
  color="success"
  location="top"
  timeout="3000"
>
  Paciente salvo com sucesso
</v-snackbar>
   

  <v-card>
    <v-card-title class="d-flex align-center justify-space-between">
      <span>Lista de Pacientes</span>

      <div class="d-flex align-center">
        <v-text-field
          v-model="filtroNome"
          label="Pesquisar por nome"
          density="compact"
          prepend-inner-icon="mdi-magnify"
          class="mr-3"
          hide-details
          style="width: 300px"
        />

        <v-btn
          color="primary"
          prepend-icon="mdi-plus"
          @click="dialog = true"
        >
          Cadastrar
        </v-btn>

        
      </div>
    </v-card-title>

    <v-divider />

    <v-data-table
  :headers="headers"
  :items="pacientesFiltrados"
  item-key="id"
>
  <template #item.dias_semana="{ item }">
    {{ diasMap[item.dias_semana] || '-' }}
  </template>

  <template #item.sala="{ item }">
    {{ salasMap[item.sala] || '-' }}
  </template>

  <template #item.turno="{ item }">
    {{ turnoMap[item.turno] || '-' }}
  </template>

  <template #item.acoes="{ item }">
    <v-btn
      size="small"
      icon="mdi-delete"
      variant="text"
      color="red"
      @click="deletarPaciente(item.id)"
    />
  </template>
</v-data-table>

  </v-card>

  <!-- MODAL -->
  <PacienteCreate
    v-model="dialog"
    @salvo="onPacienteSalvo"
  />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import PacienteService from '@/services/PacienteService'
import PacienteCreate from './PacienteCreate.vue'
import { inject } from 'vue'

const snackbar = inject('snackbar')

/* estado */
const pacientes = ref([])
const filtroNome = ref('')
const dialog = ref(false)
const alertSucesso = ref(false)

const diasMap = {
  1: 'Seg, Qua, Sex',
  2: 'Ter, Qui, Sab',
}

const salasMap = {
  1: 'Sala 01',
  2: 'Sala 02',
  3: 'Sala 03',
  4: 'Sala 04',
  5: 'Sala 05',
  6: 'Sala 06',
  7: 'Sala 07',
  8: 'Sala 08',
  9: 'Sala 09',
  10: 'Sala 10',
  11: 'Sala 11',
  12: 'Sala C',
}

const turnoMap = {
  1: 'Manhã',
  2: 'Tarde',
  3: 'Noite',
}


/* tabela */
const headers = [
  { title: 'Nome', key: 'nome_completo' },
  { title: 'Dias da semana', key: 'dias_semana' },
  { title: 'Sala', key: 'sala' },
  { title: 'Turno', key: 'turno' },
  { title: 'Ações', key: 'acoes', sortable: false },
]

/* filtros */
const pacientesFiltrados = computed(() => {
  if (!filtroNome.value) return pacientes.value
  return pacientes.value.filter(p =>
    p.nome.toLowerCase().includes(filtroNome.value.toLowerCase())
  )
})

/* ações */
function carregarPacientes() {
  PacienteService.listar()
    .then(res => pacientes.value = res.data)
}

function onPacienteSalvo() {
  carregarPacientes()
  alertSucesso.value = true

  snackbar.value.text = 'Paciente salvo com sucesso'
  snackbar.value.color = 'success'
  snackbar.value.show = true
}

function deletarPaciente(id) {
  if (confirm('Deseja deletar este paciente?')) {
    PacienteService.deletar(id)
      .then(carregarPacientes)
  }
}

onMounted(carregarPacientes)
</script>


<style>

</style>