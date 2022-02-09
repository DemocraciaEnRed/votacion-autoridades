<template>
  <section id="planchas" class="section has-background-white">
    <div class="container">
      <h2 class="title is-2 has-text-centered">
        Planchas
        <span class="has-tooltip">
          candidatas
          <b-tooltip type="is-white" position="is-right" size="is-large" multilined>
            <icon icon="question" />
            <template v-slot:content>
              <p>Las planchas candidatas responden a la pregunta: <strong>“¿a quién o a quiénes puedo votar en estas elecciones?”</strong></p>
              <p>Una plancha está conformada por un “equipo” de candidatos y candidatas, que se postulan a los distintos cargos al interior de un bloque.</p>
              <p>Cada plancha puede presentar postulantes para todos los bloques, o bien puede hacerlo solo para algunos.</p>
            </template>
          </b-tooltip>
        </span>
      </h2>
      <hr class="hr-title" />
      <div class="columns is-multiline is-centered">
        <Plate v-for="plate in plates" :key="`plate${plate.id}`" :plate="plate" />
      </div>
    </div>
  </section>
</template>

<script>
import Plate from '@/components/plate/Plate';

export default {
  name: 'RowPlates',
  components: {
    Plate,
  },
  computed: {
    plates() {
      return this.$store.state.plates;
    },
  },
};
</script>
