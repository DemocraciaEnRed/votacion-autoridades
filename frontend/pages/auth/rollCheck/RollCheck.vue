<template>
  <main class="section">
    <div class="container">
      <div class="has-text-centered">
        <transition name="fade" mode="out-in">
          <RollCheckForm v-if="auth.roll_check_step == 0" />
          <RollCheckRolled v-if="auth.roll_check_step == 1" />
          <RollCheckRegistered v-if="auth.roll_check_step == 2" />
        </transition>
      </div>
    </div>
  </main>
</template>

<script>
import RollCheckForm from './RollCheckForm';
import RollCheckRolled from './RollCheckRolled';
import RollCheckRegistered from './RollCheckRegistered';

export default {
  name: 'RollCheck',
  components: {
    RollCheckForm,
    RollCheckRolled,
    RollCheckRegistered,
  },
  computed: {
    auth() {
      return this.$store.state.auth;
    },
  },
  beforeRouteLeave(to, from, next) {
    if (to.name != 'register') {
      this.$store.dispatch('resetAuth');
    }
    next();
  },
};
</script>
