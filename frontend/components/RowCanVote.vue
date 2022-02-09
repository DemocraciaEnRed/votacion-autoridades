<template>
  <section class="section py-6 has-background-white">
    <div class="container has-text-centered">
      <div class="is-block is-flex-tablet is-justify-content-center is-align-items-center">
        <h2 class="title is-3 mb-3 mb-0-tablet mb-0 mr-6-tablet">¿Puedo Votar?</h2>
        <router-link :to="{ name: 'roll-check' }" class="button is-info">Consultar mis datos</router-link>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'RowCanVote',
};
</script>
