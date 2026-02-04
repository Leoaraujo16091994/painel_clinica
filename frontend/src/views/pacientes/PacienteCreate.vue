<template>
  <v-dialog v-model="dialog" max-width="500">
    <v-card>
      <v-card-title>Cadastrar Paciente</v-card-title>

      <v-card-text>
        <v-form v-model="formValido">
          <v-text-field
            label="Nome"
            v-model="form.nome_completo"
            :rules="[(v) => !!v || 'Nome é obrigatório']"
          />

          <v-select
            label="Dias de Atendimento"
            v-model="form.dias_semana"
            :items="opcoesDia"
            item-title="label"
            item-value="value"
            :rules="[(v) => !!v || 'Campo obrigatório']"
          />

          <v-select
            label="Sala"
            v-model="form.sala"
            :items="salas"
            item-title="label"
            item-value="value"
            :rules="[(v) => !!v || 'Campo obrigatório']"
          />

          <v-select
            label="Turno"
            v-model="form.turno"
            :items="turno"
            item-title="label"
            item-value="value"
            :rules="[(v) => !!v || 'Campo obrigatório']"
          />
        </v-form>
      </v-card-text>

      <v-card-actions class="justify-end">
        <v-btn variant="elevated" color="error" @click="fechar">
          Cancelar
        </v-btn>

        <v-btn
          variant="elevated"
          color="success"
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
import { ref, computed } from "vue";
import PacienteService from "@/services/PacienteService";

/* props */
const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  },
});

/* emits */
const emit = defineEmits(["update:modelValue", "salvo"]);

/* v-model proxy */
const dialog = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});

/* form */
const formValido = ref(false);

const form = ref({
  nome_completo: "",
  dias_semana: null,
  sala: null,
  turno: null,
});

const opcoesDia = [
  { label: "1 - Seg, Qua, Sex", value: 1 },
  { label: "2 - Ter, Qui, Sab", value: 2 },
];

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

const turno = [
  { label: "Manhã", value: 1 },
  { label: "Tarde", value: 2 },
  { label: "Noite", value: 3 },
];

function limpar() {
  form.value = {
    nome_completo: "",
    dias_semana: null,
    sala: null,
    turno: null,
  };
}

function fechar() {
  dialog.value = false;
  limpar();
}

function salvar() {
  PacienteService.criar(form.value).then(() => {
    emit("salvo");
    fechar();
  });
}
</script>
