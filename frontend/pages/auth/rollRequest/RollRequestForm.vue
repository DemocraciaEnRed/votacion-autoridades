<template>
  <div class="box is-small">
    <div class="box-inner">
      <div class="icon-wrapper mb-4">
        <icon class="has-text-primary" icon="exclamation" size="3x" />
      </div>
      <h1 class="title has-text-primary is-4 mb-6">
        Parece que no estás en el padrón
      </h1>
      <h2 class="subtitle mb-6">
        Si quieres participar, proporcionanos un mail para que se contacten con vos
      </h2>
      <form @submit.prevent="submit">
        <b-field label="Email" :type="email.type" :message="email.message" class="mb-5">
          <b-input v-model="auth.form.email"></b-input>
        </b-field>
        <!-- prettier-ignore -->
        <button
          class="button is-primary is-fullwidth"
          :class="{ 'is-loading': loading }"
          :disabled="auth.form.email ? false : true"
          type="submit"
        >
          Enviar solicitud
        </button>
      </form>

      <router-link :to="{ name: 'roll-check' }" class="button is-primary is-outlined is-fullwidth mt-4">
        Volver a verificar
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RollRequestForm',
  data() {
    return {
      loading: false,
      email: {
        type: '',
        message: '',
      },
    };
  },
  computed: {
    auth() {
      return this.$store.state.auth;
    },
  },
  methods: {
    cleanErrors() {
      this.email.type = '';
      this.email.message = '';
    },
    showErrors(data) {
      this.email.type = 'is-danger';
      this.email.message = data.message;
    },
    async submit() {
      this.loading = true;
      this.cleanErrors();

      await axios
        .post('/api/auth/take-census', {
          email: this.auth.form.email,
        })
        .then(() => {
          this.auth.roll_request_step = 1; //# 1.RollRequestSent
        })
        .catch((err) => {
          const res = err.response;
          if (res.status != 200) this.showErrors(res.data);
        });

      this.loading = false;
    },
  },
};
</script>
