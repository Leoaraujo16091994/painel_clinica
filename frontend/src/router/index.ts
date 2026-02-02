// import { createRouter, createWebHistory } from 'vue-router'
// import PacienteCreate from '@/views/pacientes/PacienteCreate.vue'
// import PacienteList from '@/views/pacientes/PacienteList.vue'
// import PacienteEdit from '@/views/pacientes/PacienteEdit.vue'
// import Chamada from '@/views/Chamada/Chamada.vue'
// import Painel from '@/views/Painel/Painel.vue'
// import Home from '@/views/Home.vue'

// const router = createRouter({
//   history: createWebHistory(import.meta.env.BASE_URL),
//   routes: [
//     { path: '/', component: Home },
//     { path: '/pacientes', name: 'ListarPacientes', component: PacienteList },
//     { path: '/pacientes/create', name: 'CriarPaciente', component: PacienteCreate },
//     { path: '/pacientes/edit/:id', name: 'EditarPaciente', component: PacienteEdit, props: true },
//     { path: '/chamar-pacientes', name:'ChamarPaciente',component: Chamada },
//     { path: '/painel', name:'ChamarPaciente',component: Chamada },
  
//   ],
// })

// export default router


import { createRouter, createWebHistory } from 'vue-router'

import DefaultLayout from '@/DefaultLayout.vue'

// views
import PacienteList from '@/views/pacientes/PacienteList.vue'
import PainelView from '@/views/painel/Painel.vue'
import PainelTelaCheia from '@/views/painel/PainelTelaCheia.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    /* ======================
       SISTEMA COM LAYOUT
    ====================== */
    {
      path: '/',
      component: DefaultLayout,
      children: [
        {
          path: '',
          redirect: '/pacientes',
        },
        {
          path: 'pacientes',
          name: 'pacientes',
          component: PacienteList,
        },
        {
          path: 'chamada',
          name: 'chamada',
          component: () => import('@/views/chamada/Chamada.vue'),
        },
        {
      path: '/painel',
      name: 'painel',
      component: PainelView,
    },
      ],
    },

    /* ======================
       PAINEL (TELA CHEIA)
    ====================== */
    {
      path: '/painel-tela-cheia',
      name: 'painelTelaCheia',
      component: PainelTelaCheia,
    },
  ],
})

export default router
