export const TURNO = {
  1: 'Manhã',
  2: 'Tarde',
  3: 'Noite',
}

export const TURNOS_OPTIONS = Object.entries(TURNOS).map(([value, label]) => ({
  value: Number(value),
  label,
}))
