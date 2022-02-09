<template>
  <div class="box is-medium has-text-centered">
    <div class="box-inner">
      <div class="icon-wrapper mb-4">
        <icon class="has-text-primary" icon="check" size="3x" />
      </div>
      <h2 class="title has-text-primary is-4 mb-6" style="max-width: 30ch; margin: auto;">
        Ya completaste el registro
      </h2>
      <h2 class="subtitle mb-4">
        Te enviamos un mail para validar tu correo electrónico.
      </h2>
      <p class="mb-4" style="max-width: 60ch; margin: auto;">
        Cuando el administrador valide tus datos personales te enviaremos un correo electrónico informándote que ya puedes votar.
      </p>
      <p class="mb-6">Recuerda revisar el spam o correo no deseado.</p>
      <router-link :to="{ name: 'home' }" class="button is-primary">
        Ir al inicio
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RegisterSent',
  computed: {
    auth() {
      return this.$store.state.auth;
    },
  },
};
</script>
