<template>
  <!-- prettier-ignore -->
  <radial-progress-bar
    :completed-steps="completedSteps"
    :total-steps="totalSteps"
    :diameter="diameter"
    :start-color="startColor"
    :stop-color="stopColor"
    :inner-stroke-color="innerStrokeColor"
    :stroke-width="strokeWidth"
    :animate-speed="animateSpeed"
  >
    <div class="radial-progress-data">
      <span class="radial-progress-data-completed">{{ completedSteps }}</span>/<span>{{ totalSteps }}</span>
    </div>
  </radial-progress-bar>
</template>

<script>
import RadialProgressBar from 'vue-radial-progress';

export default {
  name: 'Progress',
  components: {
    RadialProgressBar,
  },
  props: {
    completedSteps: Number,
    totalSteps: Number,
  },
  data() {
    return {
      diameter: 60,
      startColor: '#f06543',
      stopColor: '#f06543',
      innerStrokeColor: 'transparent',
      strokeWidth: 5,
      animateSpeed: 300,
    };
  },
};
</script>
