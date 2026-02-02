<template>
  <v-container fluid>
    <!-- BOTÃO CADASTRAR -->
    <v-row class="mb-4">
      <v-col cols="12" class="text-right">
        <v-btn color="primary" @click="abrirCadastro">
          <v-icon start>mdi-plus</v-icon>
          Cadastrar Paciente
        </v-btn>
      </v-col>
    </v-row>

    <v-row>
      <!-- SALA 01 -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="bg-primary text-white">
            Chamados da Sala 01
          </v-card-title>

          <v-list>
            <v-list-item
              v-for="(p, i) in sala1"
              :key="i"
            >
              <v-list-item-title>
                {{ i + 1 }}. {{ p }}
              </v-list-item-title>

              <template #append>
                <v-btn icon="mdi-phone" color="green" variant="text" />
                <v-btn icon="mdi-close" color="red" variant="text" />

                <v-menu>
                  <template #activator="{ props }">
                    <v-btn v-bind="props" icon="mdi-dots-vertical" variant="text" />
                  </template>

                  <v-list density="compact">
                    <v-list-item @click="abrirEdicao(p)">
                      <v-icon start>mdi-pencil</v-icon>
                      Editar
                    </v-list-item>

                    <v-list-item @click="removerPaciente(p)">
                      <v-icon start color="red">mdi-trash-can</v-icon>
                      Remover
                    </v-list-item>
                  </v-list>
                </v-menu>
              </template>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>

      <!-- SALA 02 -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="bg-success text-white">
            Chamados da Sala 02
          </v-card-title>

          <v-list>
            <v-list-item
              v-for="(p, i) in sala2"
              :key="i"
            >
              <v-list-item-title>
                {{ i + 1 }}. {{ p }}
              </v-list-item-title>

              <template #append>
                <v-btn icon="mdi-phone" color="green" variant="text" />
                <v-btn icon="mdi-close" color="red" variant="text" />

                <v-menu>
                  <template #activator="{ props }">
                    <v-btn v-bind="props" icon="mdi-dots-vertical" variant="text" />
                  </template>

                  <v-list density="compact">
                    <v-list-item @click="abrirEdicao(p)">
                      <v-icon start>mdi-pencil</v-icon>
                      Editar
                    </v-list-item>

                    <v-list-item @click="removerPaciente(p)">
                      <v-icon start color="red">mdi-trash-can</v-icon>
                      Remover
                    </v-list-item>
                  </v-list>
                </v-menu>
              </template>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
    </v-row>

    <!-- MODAL CADASTRO -->
    <v-dialog v-model="modalCadastro" max-width="400">
      <v-card>
        <v-card-title>Cadastrar Paciente</v-card-title>

        <v-card-text>
          <v-text-field
            label="Nome"
            v-model="formCadastro.nome"
          />

          <v-select
            label="Sala"
            :items="salas"
            v-model="formCadastro.sala"
          />
        </v-card-text>

        <v-card-actions class="justify-end">
          <v-btn variant="text" @click="modalCadastro = false">Cancelar</v-btn>
          <v-btn color="primary" @click="salvarCadastro">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- MODAL EDIÇÃO -->
    <v-dialog v-model="modalEdicao" max-width="400">
      <v-card>
        <v-card-title>Editar Paciente</v-card-title>

        <v-card-text>
          <v-text-field
            label="Nome"
            v-model="formEdicao.nome"
            disabled
          />

          <v-select
            label="Trocar Sala"
            :items="salas"
            v-model="formEdicao.sala"
          />
        </v-card-text>

        <v-card-actions class="justify-end">
          <v-btn variant="text" @click="modalEdicao = false">Cancelar</v-btn>
          <v-btn color="primary" @click="salvarEdicao">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>
<script setup>
import { ref } from 'vue'

const sala1 = ref([
  'Ana Paula Santos',
  'Rafael Gomes',
  'Maria Souza',
  'Pedro Almeida',
])

const sala2 = ref([
  'Carlos Oliveira',
  'Juliana Pereira',
  'Rafael Gomes',
  'Babaela Rocha',
])

const salas = [
  'Sala 01', 'Sala 02', 'Sala 03', 'Sala 04', 'Sala 05',
  'Sala 06', 'Sala 07', 'Sala 08', 'Sala 09', 'Sala 10',
  'Sala 11', 'Sala C'
]

const modalCadastro = ref(false)
const modalEdicao = ref(false)

const formCadastro = ref({
  nome: '',
  sala: null,
})

const formEdicao = ref({
  nome: '',
  sala: null,
})

function abrirCadastro() {
  formCadastro.value = { nome: '', sala: null }
  modalCadastro.value = true
}

function salvarCadastro() {
  console.log('Cadastrar:', formCadastro.value)
  modalCadastro.value = false
}

function abrirEdicao(nome) {
  formEdicao.value = {
    nome,
    sala: null,
  }
  modalEdicao.value = true
}

function salvarEdicao() {
  console.log('Editar:', formEdicao.value)
  modalEdicao.value = false
}

function removerPaciente(nome) {
  if (confirm(`Remover ${nome}?`)) {
    console.log('Removido:', nome)
  }
}
</script>
