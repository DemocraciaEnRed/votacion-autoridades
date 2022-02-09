<template>
  <section id="bloques" class="section">
    <div class="container">
      <h2 class="title is-2 has-text-centered">
        Bloques a
        <span class="has-tooltip">
          votar
          <b-tooltip type="is-white" position="is-right" size="is-large" multilined>
            <icon icon="question" />
            <template v-slot:content>
              <p>Los bloques a votar responden a la pregunta: <strong>“¿qué cargos voto en estas elecciones?”</strong></p>
              <p>Un bloque está conformado por uno o diversos cargos, que serán ocupados por los candidatos y candidatas que ganen la elección.</p>
            </template>
          </b-tooltip>
        </span>
      </h2>
      <hr class="hr-title" />
      <div class="columns is-multiline is-centered">
        <!-- prettier-ignore -->
        <div
          v-for="block in blocks" :key="`block${block.id}`" 
          class="column is-one-fifth-widescreen is-4-desktop is-6-tablet"
        >
          <div class="box has-text-centered py-6 is-fullheight">
            <h3 class="mb-55">
              Bloque<br />
              <span class="title is-5">
                {{ block.name }}
              </span>
            </h3>
            <ul class="list">
              <li v-for="position in block.positions" :key="position.id" class="list-item">
                {{ position.name }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'RowBlocks',
  computed: {
    blocks() {
      return this.$store.state.blocks;
    },
  },
};
</script>
