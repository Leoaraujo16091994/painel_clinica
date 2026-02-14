<template>
  <v-dialog v-model="model" max-width="400">
    <v-card>
      <v-card-title class="text-h6 bg-primary text-white">
        Trocar Sala
      </v-card-title>

      <v-card-text>
        <v-text-field
          label="Paciente"
          :model-value="paciente?.paciente?.nome_completo"
          disabled
        />

        <v-select
          label="Nova Sala"
          :items="salas"
          v-model="salaSelecionada"
        />
      </v-card-text>

      <v-card-actions class="justify-end">
        <v-btn color="red" variant="elevated" @click="fechar">
          Cancelar
        </v-btn>

        <v-btn
          color="green"
          variant="elevated"
          :disabled="!salaSelecionada"
          @click="confirmar"
        >
          Salvar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  paciente: Object,
  salas: {
    type: Array,
    required: true
  }
})

const emit = defineEmits(['update:modelValue', 'confirmar'])

const model = ref(props.modelValue)
const salaSelecionada = ref(null)

watch(() => props.modelValue, v => model.value = v)
watch(model, v => emit('update:modelValue', v))

watch(
  () => props.paciente,
  (p) => {
    salaSelecionada.value = p?.sala_dia ?? null
  },
  { immediate: true }
)

function fechar() {
  model.value = false
}

function confirmar() {
  emit('confirmar', salaSelecionada.value)
  model.value = false
}
</script>
