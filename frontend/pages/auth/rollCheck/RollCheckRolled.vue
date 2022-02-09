<template>
  <div class="box is-small">
    <div class="box-inner">
      <div class="icon-wrapper mb-4">
        <icon class="has-text-primary" icon="check" size="3x" />
      </div>
      <h1 class="title has-text-primary is-4">
        Te encuentras en el censo
      </h1>
      <p class="my-5" style="max-width: 55ch; margin: auto;">
        Para poder participar necesitamos que registres tus datos en la plataforma
      </p>
      <router-link :to="{ name: 'register' }" class="button is-primary is-fullwidth">
        Registrarme
      </router-link>
      <router-link :to="{ name: 'home' }" class="button is-primary is-outlined is-fullwidth mt-4">
        Volver al inicio
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RollCheckRolled',
};
</script>
