<template>
  <footer class="section pb-5 has-background-primary-dark has-text-white">
    <div class="container">
      <div class="columns mb-6">
        <div class="column is-8-tablet is-5-widescreen is-offset-1">
          <ul class="break-2 has-text-centered has-text-left-tablet">
            <!--
            //# Footer Results -->
            <template v-if="voting.data.state_id == 4">
              <li>
                <router-link :to="{ name: 'home', hash: '#datos-de-participacion' }" class="button is-ghost has-text-white">Datos de participación</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'home', hash: '#designacion-de-cargos' }" class="button is-ghost has-text-white">Designación de cargos</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'home', hash: '#resultados-de-votacion' }" class="button is-ghost has-text-white">Resultados de votación</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'home', hash: '#informacion-extra' }" class="button is-ghost has-text-white">Información extra</router-link>
              </li>
            </template>
            <!--
            //# Footer Pre-Voting & Voting -->
            <template v-if="voting.data.state_id < 3">
              <li>
                <router-link :to="{ name: 'home', hash: '#how-to' }" class="button is-ghost has-text-white">¿Cómo votar?</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'home', hash: '#bloques' }" class="button is-ghost has-text-white">Bloques a votar</router-link>
              </li>
              <li v-if="voting.data.state_id < 3">
                <router-link :to="{ name: 'home', hash: '#planchas' }" class="button is-ghost has-text-white">Planchas candidatas</router-link>
              </li>
            </template>
            <!--
            //# Footer Allways -->
            <li>
              <router-link :to="{ name: 'about' }" class="button is-ghost has-text-white">Sobre Nosotros</router-link>
            </li>
            <li>
              <router-link :to="{ name: 'terms' }" class="button is-ghost has-text-white">Términos y condiciones</router-link>
            </li>
          </ul>
        </div>
      </div>
      <div class="is-flex is-justify-content-center is-align-items-center">
        <img class="mr-2" src="/img/logo-democracia-en-red.png" width="30" height="30" />
        <span>Desarrollado con</span>
        <span class="mt-05 mx-1 has-text-danger">❤</span>
        <span>por Democracia en Red</span>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'TheFooter',
  computed: {
    voting() {
      return this.$store.state.voting;
    },
  },
};
</script>
