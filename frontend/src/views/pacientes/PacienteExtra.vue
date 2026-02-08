<template>
  <v-dialog v-model="dialog" max-width="500">
    <v-card>
      <v-card-title class="text-h6 bg-primary text-white">
        {{ form.id ? "Editar Paciente" : "Cadastrar Paciente" }}
      </v-card-title>

      <v-card-text>
        <v-form v-model="formValido">
          <v-autocomplete
            v-model="form.paciente_id"
            :items="pacientes"
            item-title="nome_completo"
            item-value="id"
            label="Paciente"
            clearable
            :rules="[(v) => !!v || 'Paciente é obrigatório']"
          />

          <v-select
            label="Sala"
            v-model="form.sala"
            :items="salas"
            item-title="label"
            item-value="value"
            :rules="[(v) => !!v || 'Campo obrigatório']"
          />
        </v-form>
      </v-card-text>

      <v-card-actions class="justify-end">
        <v-btn color="red" variant="elevated" @click="fechar">
          Cancelar
        </v-btn>

        <v-btn
          color="green"
          variant="elevated"
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
import { ref, computed, watch, onMounted } from "vue";
import PacienteService from "@/services/PacienteService";
import PacienteDiaService from "@/services/PacienteDiaService";

/* props */
const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  },
});

/* emits */
const emit = defineEmits(["update:modelValue", "salvo"]);

/* dialog proxy */
const dialog = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});

/* form */
const formValido = ref(false);

const form = ref({
  paciente_id: null,
  sala: null,
});

/* pacientes para o autocomplete */
const pacientes = ref([]);

/* salas */
const salas = [
  { label: "Sala 01", value: 1 },
  { label: "Sala 02", value: 2 },
  { label: "Sala 03", value: 3 },
  { label: "Sala 04", value: 4 },
  { label: "Sala 05", value: 5 },
  { label: "Sala 06", value: 6 },
  { label: "Sala 07", value: 7 },
  { label: "Sala 08", value: 8 },
  { label: "Sala 09", value: 9 },
  { label: "Sala 10", value: 10 },
  { label: "Sala 11", value: 11 },
  { label: "Sala C", value: 12 },
];

/* carregar pacientes ao abrir o modal */
watch(dialog, (aberto) => {
  if (aberto) {
    carregarPacientes();
  }
});

/* ações */
function limpar() {
  form.value = {
    paciente_id: null,
    sala: null,
  };
}

function fechar() {
  dialog.value = false;
  limpar();
}

function salvar() {
  if (!formValido.value) return;

  PacienteDiaService.criar(form.value).then(() => {
    emit("salvo");
    fechar();
  });
}

/* services */
function carregarPacientes() {
  PacienteService.listar().then((res) => {
    pacientes.value = res.data;
  });
}
</script>
