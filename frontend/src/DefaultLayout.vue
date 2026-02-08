<template>
  <v-app>
    <v-snackbar
  v-model="snackbar.show"
  :color="snackbar.color"
  location="top"
  timeout="3000"
>
  {{ snackbar.text }}
</v-snackbar>

    <!-- Menu lateral -->
    <v-navigation-drawer
      v-model="drawer"
      width="260"
      class="drawer-custom"
    >
      <v-list>
        <v-list-item
          title="CENEC"
          subtitle="Sistema"
          class="menu-title"
        />

        <v-divider class="my-2" />

        <v-list-item
          prepend-icon="mdi-home"
          title="Home"
          class="menu-item"
          @click="irPara('/')"
        />

        <v-list-item
          prepend-icon="mdi-account-multiple"
          title="Pacientes"
          class="menu-item"
          @click="irPara('/paciente')"
        />
        <v-list-item
          prepend-icon="mdi-account-multiple"
          title="Informar Chegada"
          class="menu-item"
          @click="irPara('/chegada')"
        />
         <v-list-item
          prepend-icon="mdi-account-multiple"
          title="Chamar Pacientes"
          class="menu-item"
          @click="irPara('/chamada')"
        />

         <v-list-item
          prepend-icon="mdi-account-multiple"
          title="Painel"
          class="menu-item"
          @click="irPara('/painel')"
        />

        <v-list-item
          prepend-icon="mdi-account-multiple"
          title="Painel TELA CHEIA"
          class="menu-item"
          @click="irPara('/painel-tela-cheia')"
        />
      </v-list>
    </v-navigation-drawer>

    <!-- Toolbar -->
    <v-app-bar color="primary" elevation="2">
      <v-app-bar-nav-icon @click="drawer = !drawer" />
      <v-app-bar-title class="text-white">
        <!-- Painel Clínica -->
      </v-app-bar-title>

      <v-spacer />

      <v-btn icon="mdi-magnify" color="white" />
      <v-btn icon="mdi-bell" color="white" />
      <v-btn icon="mdi-dots-vertical" color="white" />
    </v-app-bar>

    <!-- Conteúdo -->
    <v-main class="content-bg">
      <v-container fluid class="pa-6">
        <router-view />
      </v-container>
    </v-main>
  </v-app>
</template>


<script setup>
import { useRouter } from "vue-router";
import { ref, provide } from 'vue'

const drawer = ref(true);
const router = useRouter();

function irPara(path) {
  router.push(path);
}

const snackbar = ref({
  show: false,
  text: '',
  color: 'success'
})

provide('snackbar', snackbar)

</script>
<style scoped>
.drawer-custom {
  border-right: 1px solid #e0e0e0;
  background-color: #ffffff;
}

.menu-title {
  color: #0D47A1;
  font-weight: 600;
}

.menu-item {
  color: #0D47A1;
}

.menu-item .v-icon {
  color: #0D47A1;
}

.content-bg {
  background-color: #f5f7fa;
}
</style>
