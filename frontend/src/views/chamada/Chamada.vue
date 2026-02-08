<template>
   <v-snackbar v-model="snackbar.show" :color="snackbar.color" location="top" timeout="3000">
    {{ snackbar.text }}
  </v-snackbar>
  <v-container fluid>
    <v-row>
      <v-col
        v-for="sala in salasPermitidas" :key="sala" cols="12" md="6" >
        <v-card>
          <v-card-title class="bg-primary text-white">
            Sala {{ sala }}
          </v-card-title>

          <v-list>
            <v-list-item v-for="(p, i) in pacientesPorSala(sala)" :key="p.id" >
              <v-list-item-title>
                {{ i + 1 }}. {{ p.paciente.nome_completo }}
              </v-list-item-title>

              <v-list-item-subtitle>
                <span v-if="p.chegou" class="text-success">Chegou</span>
                <span v-else class="text-grey">Não chegou</span>
                •
                <span v-if="p.chamado" class="text-primary">Chamado</span>
                <span v-else class="text-grey">Não chamado</span>
              </v-list-item-subtitle>

              <template #append>
                <!-- CHAMAR -->
                <v-btn icon="mdi-phone" color="green" variant="text" :disabled="!p.chegou || p.chamado" @click="abrirModalChamarPaciente(p)" />

                <!-- MENU -->
                <v-menu>
                  <template #activator="{ props }">
                    <v-btn v-bind="props" icon="mdi-dots-vertical" variant="text" />
                  </template>

                  <v-list density="compact">
                    <v-list-item @click="abrirTrocaSala(p)">
                      <v-icon start>mdi-swap-horizontal</v-icon>
                      Trocar Sala
                    </v-list-item>
                  </v-list>
                </v-menu>
              </template>
            </v-list-item>

            <v-list-item v-if="pacientesPorSala(sala).length === 0">
              <v-list-item-title class="text-grey">
                Nenhum paciente
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
    </v-row>

    <!-- MODAL TROCA DE SALA -->
    <v-dialog v-model="dialogTrocarSala" max-width="400">
      <v-card>
        <v-card-title class="text-h6 bg-primary text-white">Trocar Sala</v-card-title>

        <v-card-text>
          <v-text-field label="Paciente" :model-value="pacienteSelecionado?.paciente.nome_completo" disabled />
          <v-select label="Nova Sala" :items="salas" v-model="novaSala" />
        </v-card-text>

        <v-card-actions class="justify-end">
          <v-btn color="red" variant="elevated" @click="dialogTrocarSala = false">Cancelar</v-btn>
          <v-btn color="green" variant="elevated" @click="confirmarTrocaSala">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


    <!-- MODAL CONFIRMAR CHAMADA  -->
  <v-dialog v-model="dialogChamada" max-width="420">
    <v-card>
      <v-card-title class="text-h6 bg-primary text-white">
        Confirmar chamada
      </v-card-title>

      <v-card-text>
        Tem certeza que deseja chamar o paciente
        <strong>{{ pacienteSelecionado?.paciente.nome_completo }}</strong>?
      </v-card-text>

      <v-card-actions class="justify-end">
        <v-btn color="red" variant="elevated" @click="dialogChamada = false">
          Cancelar
        </v-btn>

        <v-btn color="green" variant="elevated" @click="confirmarChamada(pacienteSelecionado)">
          Confirmar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  </v-container>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue'
import PacienteDiaService from '@/services/PacienteDiaService'

// Todas as salas possíveis
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

// 🔐 Exemplo: vindo do backend conforme perfil logado
const salasPermitidas = ref([1, 2])

// Lista completa do dia
const pacientesDoDia = ref([])

const dialogTrocarSala = ref(false)
const dialogChamada = ref(false)
const pacienteSelecionado = ref(null)
const novaSala = ref(null)

const snackbar = inject('snackbar')

// 🔄 Carregar pacientes do dia
async function carregarPacientes() {
  const { data } = await PacienteDiaService.listar();
  pacientesDoDia.value = data
}

// 📌 Filtrar por sala
function pacientesPorSala(sala) {
  return pacientesDoDia.value.filter(p => p.sala_dia === sala)
}

function abrirModalChamarPaciente(paciente) {
  pacienteSelecionado.value = paciente
  dialogChamada.value = true
}

// 📞 Chamar paciente
function confirmarChamada(paciente) {
   PacienteDiaService.confirmarChamada(paciente.id).then(() => {
    paciente.chamado = true

    snackbar.value.text = "Chamada confirmada"
    snackbar.value.color = "success"
    snackbar.value.show = true
    dialogChamada.value = false
  })
}

// 🔁 Trocar sala
function abrirTrocaSala(paciente) {
  pacienteSelecionado.value = paciente
  novaSala.value = paciente.sala_dia
  dialogTrocarSala.value = true
}

function confirmarTrocaSala() {
  PacienteDiaService.trocarSala(pacienteSelecionado.value.id, novaSala.value)
    .then(() => {
      pacienteSelecionado.value.sala_dia = novaSala.value
      dialogTrocarSala.value = false

    snackbar.value.text = "Troca de sala confirmada"
    snackbar.value.color = "success"
    snackbar.value.show = true
    })
}
onMounted(carregarPacientes)
</script>
