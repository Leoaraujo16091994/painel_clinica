export const DIASSEMANA = {
  1: 'Seg, Qua, Sex',
  2: 'Ter, Qui, Sab',
}

export const DIAS_SEMANA_OPTIONS = Object.entries(DIAS_SEMANA).map(
  ([value, label]) => ({
    value: Number(value),
    label,
  })
)
