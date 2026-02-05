<template>
  <v-snackbar v-model="snackbar.show" :color="snackbar.color" location="top" timeout="3000">
    {{ snackbar.text }}
  </v-snackbar>

  <v-card>
    <v-card-title class="d-flex align-center justify-space-between">
      <span>Lista de Pacientes</span>

      <div class="d-flex align-center">
        <v-text-field v-model="filtroNome" label="Pesquisar por nome" density="compact" prepend-inner-icon="mdi-magnify" class="mr-3" hide-details style="width: 300px" />

        <v-btn color="primary" prepend-icon="mdi-plus" @click="abrirCadastro">
          Cadastrar
        </v-btn>
      </div>
    </v-card-title>

    <v-divider />

    <v-data-table :headers="headers" :items="pacientesFiltrados" item-key="id">
      <template #item.dias_semana="{ item }">
        {{ diasMap[item.dias_semana] || "-" }}
      </template>

      <template #item.sala="{ item }">
        {{ salasMap[item.sala] || "-" }}
      </template>

      <template #item.turno="{ item }">
        {{ turnoMap[item.turno] || "-" }}
      </template>

      <template #item.acoes="{ item }">
        <v-btn size="small" icon="mdi-pencil" variant="text" color="primary" @click="editarPaciente(item)"/>
        <v-btn size="small" icon="mdi-delete" variant="text" color="red" @click="abrirConfirmacaoDelete(item)" />
      </template>
    </v-data-table>
  </v-card>

  <!-- MODAL CADASTRO / EDIÇÃO -->
  <PacienteCreate v-model="dialog" :paciente="pacienteSelecionado" @salvo="onPacienteSalvo" />

  <!-- MODAL CONFIRMAÇÃO DELETE -->
  <v-dialog v-model="dialogDelete" max-width="420">
    <v-card>
      <v-card-title class="text-h6">
        Confirmar exclusão
      </v-card-title>

      <v-card-text>
        Tem certeza que deseja remover o paciente
        <strong>{{ pacienteSelecionado?.nome_completo }}</strong>?
      </v-card-text>

      <v-card-actions class="justify-end">
        <v-btn variant="text" @click="dialogDelete = false">
          Cancelar
        </v-btn>

        <v-btn color="red" variant="elevated" @click="confirmarDelete">
          Excluir
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, computed, onMounted, inject } from "vue"
import PacienteService from "@/services/PacienteService"
import PacienteCreate from "./PacienteCreate.vue"

const snackbar = inject("snackbar")

const pacientes = ref([])
const filtroNome = ref("")
const dialog = ref(false)
const dialogDelete = ref(false)
const pacienteSelecionado = ref(null)

const diasMap = {
  1: "Seg, Qua, Sex",
  2: "Ter, Qui, Sab",
}

const salasMap = {
  1: "Sala 01",
  2: "Sala 02",
  3: "Sala 03",
  4: "Sala 04",
  5: "Sala 05",
  6: "Sala 06",
  7: "Sala 07",
  8: "Sala 08",
  9: "Sala 09",
  10: "Sala 10",
  11: "Sala 11",
  12: "Sala C",
}

const turnoMap = {
  1: "Manhã",
  2: "Tarde",
  3: "Noite",
}

/* tabela */
const headers = [
  { title: "Nome", key: "nome_completo" },
  { title: "Dias da semana", key: "dias_semana" },
  { title: "Sala", key: "sala" },
  { title: "Turno", key: "turno" },
  { title: "Ações", key: "acoes", sortable: false },
]

/* filtros */
const pacientesFiltrados = computed(() => {
  if (!filtroNome.value) return pacientes.value
  return pacientes.value.filter(p =>
    p.nome_completo.toLowerCase().includes(filtroNome.value.toLowerCase())
  )
})

/* ações */
function carregarPacientes() {
  PacienteService.listar().then(res => {
    pacientes.value = res.data
  })
}

function abrirCadastro() {
  pacienteSelecionado.value = null
  dialog.value = true
}

function editarPaciente(paciente) {
  pacienteSelecionado.value = { ...paciente }
  dialog.value = true
}

function abrirConfirmacaoDelete(paciente) {
  pacienteSelecionado.value = paciente
  dialogDelete.value = true
}

function confirmarDelete() {
  PacienteService.deletar(pacienteSelecionado.value.id)
    .then(() => {
      dialogDelete.value = false
      pacienteSelecionado.value = null
      carregarPacientes()

      snackbar.value.text = "Paciente removido com sucesso"
      snackbar.value.color = "success"
      snackbar.value.show = true
    })
}

function onPacienteSalvo() {
  carregarPacientes()
  pacienteSelecionado.value = null

  snackbar.value.text = "Paciente salvo com sucesso"
  snackbar.value.color = "success"
  snackbar.value.show = true
}

onMounted(carregarPacientes)
</script>
