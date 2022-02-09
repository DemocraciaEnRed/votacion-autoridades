<template>
  <div class="modal-inner">
    <button type="button" class="delete" @click="$emit('close')" />
    <div class="box is-small has-text-centered">
      <div class="box-inner">
        <div class="icon-wrapper mb-4">
          <icon class="has-text-primary" icon="check" size="3x" />
        </div>
        <h2 class="title has-text-primary is-4 mb-5">
          Paso 1: Mail validado con éxito. Falta solo un paso para que puedas votar.
        </h2>
        <p class="mb-4">
          Cuando validemos tu datos personales recibirás un correo electrónico informándote que ya puede iniciar sesión y votar cuando sea la fecha de las elecciones.
        </p>
        <p class="mb-6">Recuerda revisar el spam o correo no deseado.</p>
        <button class="button is-primary" @click="$emit('close')">
          Entendido
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EmailVerificationModal',
};
</script>
