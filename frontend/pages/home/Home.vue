<template>
  <main>
    <HomePreVoting v-if="voting.data.state.id == 1" />
    <HomeVoting v-if="voting.data.state.id == 2" />
    <HomePreResults v-if="voting.data.state.id == 3" />
    <HomeResults v-if="voting.data.state.id == 4" />
  </main>
</template>

<script>
import HomePreVoting from './HomePreVoting';
import HomeVoting from './HomeVoting';
import HomePreResults from './HomePreResults';
import HomeResults from './HomeResults';

import EmailVerificationModal from '@/components/EmailVerificationModal';
import ChangePasswordModal from '@/components/ChangePasswordModal';

export default {
  name: 'Home',
  components: {
    HomePreVoting,
    HomeVoting,
    HomePreResults,
    HomeResults,
  },
  computed: {
    auth() {
      return this.$store.state.auth;
    },
    voting() {
      return this.$store.state.voting;
    },
  },
  methods: {
    emailVerification() {
      this.$buefy.modal.open({
        parent: this,
        component: EmailVerificationModal,
        hasModalCard: true,
        trapFocus: true,
        scroll: 'keep',
        width: 'auto',
      });
    },
    async forgotPassword() {
      await axios
        .post('/api/auth/forgot-password/validate-token', {
          token: this.$route.query.token,
        })
        .then((res) => {
          this.$store.commit('setUser', res.data.user);
          this.auth.token = this.$route.query.token;
          this.$buefy.modal.open({
            parent: this,
            component: ChangePasswordModal,
            hasModalCard: true,
            trapFocus: true,
            scroll: 'keep',
            width: 'auto',
          });
        })
        .catch((err) => {
          console.log(err.response.data.message);
        });
    },
  },
  mounted() {
    if (this.$route.query.bienvenida == 1) this.emailVerification();
    else if (this.$route.query.token) this.forgotPassword();
  },
};
</script>
