<template>
  <v-container fluid>
    <v-row>
      <v-col
        v-for="sala in salasPermitidas"
        :key="sala"
        cols="12"
        md="6"
      >
        <v-card>
          <v-card-title class="bg-primary text-white">
            Sala {{ sala }}
          </v-card-title>

          <v-list>
            <v-list-item v-for="(p, i) in pacientesPorSala(sala)" :key="p.id" >
              <v-list-item-title>
                {{ i + 1 }}. {{ p.nome_completo }}
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
                <v-btn icon="mdi-phone" color="green" variant="text" :disabled="!p.chegou || p.chamado" @click="chamarPaciente(p)" />

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
    <v-dialog v-model="modalTrocaSala" max-width="400">
      <v-card>
        <v-card-title>Trocar Sala</v-card-title>

        <v-card-text>
          <v-text-field
            label="Paciente"
            :model-value="pacienteSelecionado?.nome_completo"
            disabled
          />

          <v-select
            label="Nova Sala"
            :items="todasSalas"
            v-model="novaSala"
          />
        </v-card-text>

        <v-card-actions class="justify-end">
          <v-btn variant="text" @click="modalTrocaSala = false">Cancelar</v-btn>
          <v-btn color="primary" @click="confirmarTrocaSala">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
// import api from '@/services/api'

// 🔐 Exemplo: vindo do backend conforme perfil logado
const salasPermitidas = ref([1, 2])

// Todas as salas possíveis
const todasSalas = [
  1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 'C'
]

// Lista completa do dia
const pacientesDoDia = ref([])

const modalTrocaSala = ref(false)
const pacienteSelecionado = ref(null)
const novaSala = ref(null)

// 🔄 Carregar pacientes do dia
async function carregarPacientes() {
//   const { data } = await api.get('/pacientes-do-dia')
//   pacientesDoDia.value = data
}

// 📌 Filtrar por sala
function pacientesPorSala(sala) {
  return pacientesDoDia.value.filter(p => p.sala_dia === sala)
}

// 📞 Chamar paciente
async function chamarPaciente(paciente) {
  // await api.put(`/pacientes-do-dia/${paciente.id}`, {
  //   chamado: true
  // })

  paciente.chamado = true
}

// 🔁 Trocar sala
function abrirTrocaSala(paciente) {
  pacienteSelecionado.value = paciente
  novaSala.value = paciente.sala_dia
  modalTrocaSala.value = true
}

async function confirmarTrocaSala() {
  // await api.put(`/pacientes-do-dia/${pacienteSelecionado.value.id}`, {
  //   sala_dia: novaSala.value
  // })

  pacienteSelecionado.value.sala_dia = novaSala.value
  modalTrocaSala.value = false
}

onMounted(carregarPacientes)
</script>
