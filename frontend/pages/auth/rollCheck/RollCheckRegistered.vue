<template>
  <div class="box is-small">
    <div class="box-inner">
      <div class="icon-wrapper mb-4">
        <icon class="has-text-primary" icon="check" size="3x" />
      </div>
      <h1 class="title has-text-primary is-4 mb-5">
        Ya te encuentras registrado
      </h1>
      <p class="mb-4" style="max-width: 55ch; margin: auto;">
        Recuerda que el registro consta de dos pasos: confirmación de usuario y validación de identidad.
      </p>
      <p class="my-6" style="max-width: 55ch; margin: auto;">
        Por favor inicia sesión para poder participar
      </p>
      <p class="my-5" style="max-width: 55ch; margin: auto;"></p>
      <router-link :to="{ name: 'login' }" class="button is-primary is-fullwidth">
        Iniciar Sesión
      </router-link>
      <router-link :to="{ name: 'home' }" class="button is-primary is-outlined is-fullwidth mt-4">
        Volver al inicio
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RollCheckRegistered',
};
</script>
