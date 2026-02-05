export const SALAS = {
  1: 'Sala 01',
  2: 'Sala 02',
  3: 'Sala 03',
  4: 'Sala 04',
  5: 'Sala 05',
  6: 'Sala 06',
  7: 'Sala 07',
  8: 'Sala 08',
  9: 'Sala 09',
  10: 'Sala 10',
  11: 'Sala 11',
  12: 'Sala C',
}

export const SALAS_OPTIONS = Object.entries(SALAS).map(([value, label]) => ({
  value: Number(value),
  label,
}))
