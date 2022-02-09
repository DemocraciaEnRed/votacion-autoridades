<template>
  <div class="candidate has-text-centered has-text-left-tablet is-flex-tablet is-align-items-center">
    <figure class="image is-48x48 m-auto mb-2 m-0-tablet">
      <img class="is-rounded" :src="plate ? plate.logo : candidate.photo" />
    </figure>
    <div class="ml-3-tablet">
      <h4 class="title is-6">{{ candidate.name }} {{ candidate.last_name }}</h4>
      <p class="subtitle is-6 mb-0">{{ candidate.position.name }}</p>
      <div v-if="plate" class="plate-name mt-2" :style="`--bullet-color: ${chartColors[plate.id - 1]}`">{{ plate.name }}</div>
    </div>
  </div>
</template>

<script>
import { chartColors } from '@/js/helpers';

export default {
  name: 'Candidate',
  props: {
    candidate: Object,
    plate: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      chartColors: chartColors,
    };
  },
};
</script>
