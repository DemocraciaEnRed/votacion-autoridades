<template>
  <div class="voting-block">
    <!--
    //# Voting Plates -->
    <!-- prettier-ignore -->
    <VotingBlockPlate
      v-for="plateItem in block.plates"
      :key="`VotingBlockPlate${plateItem.plate.id}`"
      :plate="plateItem.plate"
      @select="selectPlate"
      ref="plateComponents"
    />

    <!--
    //# Blank Vote -->
    <!-- prettier-ignore -->
    <div
      class="box is-medium py-55 has-border-width-2"
      :class="isBlankSelected ? 'has-background-info-light has-border-info' : 'has-border-white'"
    >
      <div class="box-inner">
        <div class="columns is-align-items-center">
          <div class="column">
            <p class="title is-4 has-text-centered has-text-left-tablet">Quiero Votar en blanco</p>
          </div>
          <!--
          //# Select -->
          <div class="column is-narrow">
            <!-- prettier-ignore -->
            <button
              class="button is-fullwidth"
              :class="isBlankSelected ? 'is-info' : 'is-primary is-outlined'"
              @click="selectBlank"
              style="min-width:10rem"
            >
              {{ isBlankSelected ? 'Seleccionado' : 'Seleccionar' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VotingBlockPlate from './VotingBlockPlate';

export default {
  name: 'VotingBlock',
  components: {
    VotingBlockPlate,
  },
  props: {
    block: Object,
  },
  data() {
    return {
      isBlankSelected: false,
    };
  },
  computed: {
    voting() {
      return this.$store.state.voting;
    },
  },
  methods: {
    unselectAll() {
      this.$refs.plateComponents.forEach((component) => {
        component.unselect();
      });
      this.isBlankSelected = false;
    },
    selectPlate(selectedPlate) {
      this.voting.selection[this.voting.step] = {
        block_id: this.block.id,
        plate_id: selectedPlate.id,
      };
      this.unselectAll();
      // Select Correct Component
      this.$refs.plateComponents.forEach((component) => {
        if (component.plate == selectedPlate) component.select();
      });
      this.$emit('update-selection');
    },
    selectBlank() {
      this.voting.selection[this.voting.step] = {
        block_id: this.block.id,
        plate_id: null,
      };
      this.unselectAll();
      this.isBlankSelected = true;
      this.$emit('update-selection');
    },
  },
  beforeRouteLeave(to, from, next) {
    this.$store.dispatch('resetVoting');
    next();
  },
};
</script>
