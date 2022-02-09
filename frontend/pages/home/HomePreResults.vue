<template>
  <div>
    <!--
    //# Top -->
    <section class="section has-text-centered py-5">
      <div class="container">
        <h2 class="tag is-dark is-large mb-3">Conteo de votos</h2>
        <p class="has-text-weight-semibold" style="max-width: 40ch; margin: auto;">
          Recibirás un correo electrónico cuando estén disponibles los resultados de la votación
        </p>
      </div>
    </section>
    <!--
    //# Hero -->
    <section class="section has-background-white">
      <div class="container has-text-centered">
        <icon class="has-text-primary mb-4" :icon="['far', 'heart']" size="6x" />
        <h1 class="title has-text-primary is-2">Muchas gracias por participar</h1>
        <p class="subtitle is-3">Estamos contando los votos</p>
        <hr class="hr-title" />
        <p class="is-size-5" style="max-width: 50ch; margin: auto;">Pronto enviaremos un mail a todos los participantes de la votación anunciando los resultados de la misma</p>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'HomePreResults',
};
</script>
