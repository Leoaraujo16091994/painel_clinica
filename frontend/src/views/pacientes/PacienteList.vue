<template>
  <!-- Card principal -->
  <v-card>
    <!-- Cabeçalho -->
    <v-card-title class="d-flex align-center justify-space-between">
      <span>Lista de Pacientes</span>

      
      <div class="d-flex align-center">
        <!-- Campo de pesquisa -->
         
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
          @click="abrirModal"
        >
          Cadastrar
        </v-btn>
      </div>
    </v-card-title>

    <v-divider />

    <!-- Tabela -->
    <v-data-table
      :headers="headers"
      :items="pacientesFiltrados"
      item-key="id"
      class="elevation-1"
    >
      <template #item.acoes="{ item }">
        <v-btn
          size="small"
          icon="mdi-pencil"
          variant="text"
          color="primary"
        />

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

  <!-- MODAL (fora do card, MUITO importante) -->
  <v-dialog v-model="dialog" max-width="500">
    <v-card>
      <v-card-title>Cadastrar Paciente</v-card-title>

      <v-card-text>
        <v-form v-model="formValido">
          <v-text-field
            label="Nome"
            v-model="form.nome"
            :rules="[v => !!v || 'Nome é obrigatório']"
            required
          />

          <v-select
            label="Dias de Atendimento"
            v-model="form.turno"
            :items="opcoesTurno"
            item-title="label"
            item-value="value"
            :rules="[v => !!v || 'Campo obrigatório']"
            required
          />
        </v-form>
      </v-card-text>

      <v-divider />

      <v-card-actions class="justify-end">
        <v-btn variant="text" @click="fecharModal">
          Cancelar
        </v-btn>
        <v-btn
          color="primary"
          :disabled="!formValido"
          @click="salvar"
        >
          Salvar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import PacienteService from '@/services/PacienteService'

/* ------------------ LISTAGEM ------------------ */
const pacientes = ref([])
const filtroNome = ref('')

const headers = [
  { title: 'Nome', key: 'nome' },
  { title: 'Email', key: 'email' },
  { title: 'Telefone', key: 'telefone' },
  { title: 'Ações', key: 'acoes', sortable: false },
]

const pacientesFiltrados = computed(() => {
  if (!filtroNome.value) return pacientes.value

  return pacientes.value.filter(p =>
    p.nome.toLowerCase().includes(filtroNome.value.toLowerCase())
  )
})

function carregarPacientes() {
  PacienteService.listar()
    .then(res => pacientes.value = res.data)
    .catch(err => console.error(err))
}

/* ------------------ MODAL ------------------ */
const dialog = ref(false)
const formValido = ref(false)

const form = ref({
  nome: '',
  turno: null,
})

const opcoesTurno = [
  { label: '1 - Seg, Qua, Sex', value: 1 },
  { label: '2 - Ter, Qui, Sab', value: 2 },
]

function abrirModal() {
  dialog.value = true
}

function fecharModal() {
  dialog.value = false
  form.value = { nome: '', turno: null }
}

function salvar() {
  console.log('Salvar paciente:', form.value)

  // futuramente:
  // PacienteService.criar(form.value).then(carregarPacientes)

  fecharModal()
}

/* ------------------ AÇÕES ------------------ */
function deletarPaciente(id) {
  if (confirm('Deseja deletar este paciente?')) {
    PacienteService.deletar(id)
      .then(carregarPacientes)
      .catch(err => console.error(err))
  }
}

onMounted(carregarPacientes)
</script>
