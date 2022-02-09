<template>
  <div class="column is-3-widescreen is-4-desktop is-6-tablet">
    <div class="box is-fullheight has-text-centered py-6">
      <figure class="image is-78x78 is-centered mb-3">
        <img class="is-rounded" :src="plate.logo" />
      </figure>
      <h3 class="mb-4">
        Plancha<br />
        <span class="title is-5">
          {{ plate.name }}
        </span>
      </h3>
      <PlateCandidates :plate="plate" />
      <button class="button is-ghost" @click="openPlateModal">
        <span class="mr-3">Ver Detalles</span>
        <icon icon="chevron-right" />
      </button>
    </div>
  </div>
</template>

<script>
import PlateCandidates from './PlateCandidates';
import PlateModal from './PlateModal.vue';

export default {
  name: 'Plate',
  components: {
    PlateCandidates,
  },
  props: {
    plate: Object,
  },
  methods: {
    openPlateModal() {
      const _this = this;
      this.$buefy.modal.open({
        parent: this,
        component: PlateModal,
        hasModalCard: true,
        trapFocus: true,
        scroll: 'keep',
        width: 'auto',
        props: {
          plate: _this.plate,
        },
        events: {},
      });
    },
  },
};
</script>
