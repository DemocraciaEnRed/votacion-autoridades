<template>
  <div class="box is-small">
    <div class="box-inner">
      <div class="icon-wrapper mb-4">
        <icon class="has-text-primary" icon="check" size="3x" />
      </div>
      <h1 class="title has-text-primary is-4 mb-6">
        ¡Solicitud enviada con éxito!
      </h1>
      <h2 class="subtitle mb-4">
        En breve, el administrador se pondrá en contacto contigo a través del mail proporcionado:
        <div class="mt-2 is-size-4 has-text-weight-bold">{{ auth.form.email }}</div>
      </h2>
      <p class="mb-6">Recuerda revisar el spam o correo no deseado.</p>
      <router-link :to="{ name: 'home' }" class="button is-primary is-outlined is-fullwidth mt-4">
        Volver al inicio
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RollRequestSent',
  computed: {
    auth() {
      return this.$store.state.auth;
    },
  },
};
</script>
