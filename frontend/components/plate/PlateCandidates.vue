<template>
  <div>
    <div class="candidates mb-2">
      <!-- prettier-ignore -->
      <figure
        v-for="candidate in plate.candidates.slice(0, candidatesDisplayed)"
        :key="candidate.id"
        class="candidates-item image is-48x48"
      >
        <img class="is-rounded" :src="candidate.photo" />
      </figure>
      <div v-if="plate.candidates.length > candidatesDisplayed" class="candidates-plus">
        <!-- prettier-ignore -->
        <div class="is-size-6 has-text-weight-bold">
          {{ plate.candidates.length - candidatesDisplayed }}+
        </div>
      </div>
    </div>
    <div class="mb-5">{{ plate.candidates.length }} candidatos</div>
  </div>
</template>

<script>
export default {
  name: 'PlateCandidates',
  props: {
    plate: Object,
  },
  data() {
    return {
      candidatesDisplayed: 5,
    };
  },
};
</script>
