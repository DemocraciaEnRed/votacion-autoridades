<template>
  <div class="box is-medium">
    <div class="box-inner has-text-centered">
      <div class="icon-wrapper mb-4">
        <icon class="has-text-primary" icon="check" size="3x" />
      </div>
      <h1 class="title has-text-primary is-4">
        Ya enviamos tu voto
      </h1>
      <p class="my-5" style="max-width: 55ch; margin: auto;">
        Te enviaremos un correo electrónico avisándote que ya puedes ver los resultados, mientras tanto puedes ver e informarte del proceso desde la página principal.
      </p>
      <router-link :to="{ name: 'home' }" class="button is-primary">
        Ir al inicio
      </router-link>
      <div class="mt-6">
        <h2 class="tag is-dark is-medium mb-3">Conteo de Votos</h2>
        <Timer size="is-small" text="comenzará en" :finish="voting.data.day_finish" />
      </div>
    </div>
  </div>
</template>

<script>
import Timer from '@/components/Timer';

export default {
  name: 'VotingSent',
  components: {
    Timer,
  },
  computed: {
    voting() {
      return this.$store.state.voting;
    },
  },
};
</script>
