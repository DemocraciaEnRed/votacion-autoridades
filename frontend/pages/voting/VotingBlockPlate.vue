<template>
  <!-- prettier-ignore -->
  <div
    class="box is-medium py-55 has-border-width-2"
    :class="isSelected ? 'has-border-success has-background-success-light' : 'has-border-white'"
  >
    <div class="box-inner">
      <div class="columns is-multiline">
        <div class="column">
          <!--
          //# Plate -->
          <div class="has-text-centered has-text-left-tablet is-flex-tablet is-align-items-center mb-55">
            <figure class="image is-64x64 m-auto m-0-tablet">
              <img class="is-rounded" :src="plate.logo" />
            </figure>
            <h3 class="title is-5 is-4-tablet ml-3-tablet">
              <span class="has-text-weight-normal">Plancha:</span><br />
              {{ plate.name }}
            </h3>
          </div>
          <!--
          //# Candidates -->
          <div class="columns is-multiline is-mobile is-justify-content-center is-justify-content-start-tablet">
            <div v-for="candidate in plate.candidates_of_block" :key="candidate.id" class="column is-6">
            <Candidate :candidate="candidate"/>
          </div>
          </div>
        </div>

        <!--
        //# Select -->
        <div class="column is-narrow has-text-centered">
          <!-- prettier-ignore -->
          <button
            class="button"
            :class="isSelected ? 'is-success' : 'is-primary is-outlined'"
            @click="$emit('select', plate)"
            style="min-width:10rem"
          >
            {{ isSelected ? 'Seleccionado' : 'Seleccionar' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Candidate from '@/components/Candidate';
export default {
  name: 'VotingBlockPlate',
  components: {
    Candidate,
  },
  props: {
    plate: Object,
  },
  data() {
    return {
      isSelected: this.plate.selected,
    };
  },
  methods: {
    select() {
      this.plate.selected = true;
      this.isSelected = this.plate.selected;
    },
    unselect() {
      this.plate.selected = false;
      this.isSelected = this.plate.selected;
    },
  },
};
</script>
