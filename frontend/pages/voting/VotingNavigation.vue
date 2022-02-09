<template>
  <div class="section is-navigation is-sticky">
    <div class="container">
      <div class="box is-medium has-background-light py-4 mb-0">
        <div class="box-inner level" style="height: 50px;">
          <!--
          //# Navigation -->
          <div class="level-left">
            <Progress :completedSteps="voting.step + 1" :totalSteps="blocks.length" />
            <div class="has-text-primary has-text-centered has-text-left-tablet">
              <h1 class="title is-5 is-4-tablet">
                <span class="has-text-weight-normal">Bloque:</span>
                {{ blocks[voting.step].name }}
              </h1>
              <p class="subtitle is-6 is-6-tablet">Selecciona la plancha que quieres votar</p>
            </div>
          </div>
          <div class="level-right">
            <div class="buttons is-justify-content-center is-justify-content-flex-end-tablet">
              <!--
                //# Prev -->
              <button v-if="showPrev" class="button is-primary" style="width:4rem" @click="prev">
                <icon icon="chevron-left" />
              </button>
              <!--
                //# Confirm -->
              <button v-if="showConfirm" :disabled="disableConfirm" class="button is-success" @click="$emit('confirm')">
                Confirmar
              </button>
              <!--
                //# Next -->
              <button v-if="showNext" :disabled="disableNext" class="button is-primary" style="width:4rem" @click="next">
                <icon icon="chevron-right" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Progress from '@/components/Progress';

export default {
  name: 'VotingNavigation',
  components: {
    Progress,
  },
  data() {
    return {
      showPrev: false,
      disablePrev: true,
      showNext: true,
      disableNext: true,
      showConfirm: false,
      disableConfirm: true,

      completedSteps: 0,
      totalSteps: 10,
    };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    voting() {
      return this.$store.state.voting;
    },
    blocks() {
      return this.$store.state.blocks;
    },
  },
  methods: {
    handler() {
      const step = this.voting.step;
      const blocks = this.blocks.length;
      const selection = this.voting.selection.length;
      this.showPrev = step > 0;
      this.showNext = step < blocks - 1;
      this.disableNext = step >= selection;
      this.showConfirm = step == blocks - 1 || selection == blocks;
      this.disableConfirm = selection != blocks;
    },
    prev() {
      this.voting.step--;
      this.handler();
    },
    next() {
      this.voting.step++;
      this.handler();
    },
  },
};
</script>
