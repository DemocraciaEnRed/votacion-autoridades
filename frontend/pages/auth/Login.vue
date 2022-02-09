<template>
  <main class="section has-text-centered">
    <div class="container">
      <div class="box is-white is-small">
        <div class="box-inner">
          <h1 class="title has-text-primary is-4 mb-6">
            ¡Hola!
          </h1>
          <h2 class="subtitle mb-6">
            Ingresa los datos de tu cuenta para empezar a participar
          </h2>
          <form @submit.prevent="submit">
            <b-field label="Email" :type="email.type" :message="email.message">
              <b-input v-model="email.value" />
            </b-field>
            <b-field label="Contraseña">
              <b-input v-model="password.value" type="password" password-reveal />
            </b-field>
            <!-- prettier-ignore -->
            <button
              class="button is-primary is-fullwidth mt-5"
              :class="{ 'is-loading': loading }"
              :disabled="submitDisabled"
              type="submit"
            >
              Ingresar
            </button>
            <div class="mt-4">
              <a class="link" @click="openForgotPasswordModal">Olvidé mi contraseña</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import ForgotPasswordModal from '@/components/ForgotPasswordModal';

export default {
  name: 'Login',
  data() {
    return {
      loading: false,
      email: {
        value: '',
        type: '',
        message: [],
      },
      password: {
        value: '',
      },
    };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    submitDisabled() {
      return this.email.value == '' || this.password.value == '' ? true : false;
    },
  },

  methods: {
    cleanErrors() {
      this.email.type = '';
      this.email.message = [];
    },
    showErrors(errors) {
      if (errors.email) {
        this.email.type = 'is-danger';
        this.email.message = errors.email;
      }
    },
    async submit() {
      this.loading = true;
      this.cleanErrors();
      await axios.get('/sanctum/csrf-cookie').then(() => {
        axios
          .post('/api/auth/login', {
            email: this.email.value,
            password: this.password.value,
          })
          .then(() => {
            this.loading = false;
            this.$store.dispatch('logged').then(() => {
              this.$router.push({ name: 'home' });
            });
          })
          .catch((err) => {
            this.password.value = '';
            const res = err.response;
            if (res.status == 422) this.showErrors(res.data.errors);
          });
      });
      this.loading = false;
    },

    openForgotPasswordModal() {
      this.$buefy.modal.open({
        parent: this,
        component: ForgotPasswordModal,
        hasModalCard: true,
        trapFocus: true,
        scroll: 'keep',
        width: 'auto',
      });
    },
  },
};
</script>
