<template>
  <div class="modal-inner">
    <button type="button" class="delete" @click="$emit('close')" />
    <div class="box is-small has-text-centered">
      <h2 class="title is-4 has-text-primary mb-4" style="max-width: 25ch; margin:auto">¿Estás seguro que deseas salir de la votación?</h2>
      <p class="mb-5" style="max-width: 50ch; margin:auto">Al salir de la votación perderás las planchas que hayas seleccionado. ¿quieres salir de todas formas?</p>
      <div class="buttons is-justify-content-center">
        <button class="button is-primary is-outlined" @click="$emit('close')">No, cancelar</button>
        <button class="button is-danger" @click="exit">Si, quiero salir</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VotingExitModal',
  methods: {
    exit() {
      this.$emit('close');
      this.$emit('exit');
    },
  },
};
</script>
