<template>
  <div class="section">
    <div class="container has-text-centered">
      <transition name="fade" mode="out-in">
        <RollRequestForm v-if="auth.roll_request_step == 0" />
        <RollRequestSent v-if="auth.roll_request_step == 1" />
      </transition>
    </div>
  </div>
</template>

<script>
import RollRequestForm from './RollRequestForm';
import RollRequestSent from './RollRequestSent';

export default {
  name: 'RollRequest',
  components: {
    RollRequestForm,
    RollRequestSent,
  },
  computed: {
    auth() {
      return this.$store.state.auth;
    },
  },
  beforeRouteLeave(to, from, next) {
    this.$store.dispatch('resetAuth');
    next();
  },
};
</script>
