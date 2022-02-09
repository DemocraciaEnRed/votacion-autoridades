<template>
  <div class="modal-inner">
    <button type="button" class="delete" @click="$emit('close')" />
    <div class="box is-small has-text-centered">
      <div class="box-inner">
        <h1 class="title has-text-primary is-4">¡Hola {{ user.name }}!</h1>
        <h2 class="subtitle mb-6">
          Ahora puedes cambiar tu contraseña
        </h2>
        <form @submit.prevent="submit">
          <b-field label="Contraseña" :type="password.type" :message="password.message">
            <b-input v-model="password.value" type="password" password-reveal />
          </b-field>
          <b-field label="Repetir contraseña">
            <b-input v-model="password_confirmation.value" type="password" password-reveal />
          </b-field>
          <!-- prettier-ignore -->
          <button
            class="button is-primary is-fullwidth mt-5"
            :class="{ 'is-loading': loading }"
            :disabled="submitDisabled"
            type="submit"
          >
            Cambiar contraseña
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ChangePasswordModal',
  data() {
    return {
      loading: false,
      password: {
        value: '',
        type: '',
        message: [],
      },
      password_confirmation: {
        value: '',
      },
    };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    auth() {
      return this.$store.state.auth;
    },
    submitDisabled() {
      return this.password.value == '' || this.password_confirmation.value == '' ? true : false;
    },
  },
  methods: {
    cleanErrors() {
      this.password.type = '';
      this.password.message = [];
    },
    showErrors(errors) {
      if (errors.password) {
        this.password.type = 'is-danger';
        this.password.message = errors.password;
      }
    },
    async submit() {
      this.loading = true;
      this.cleanErrors();
      await axios
        .post('/api/auth/forgot-password/change-password', {
          token: this.auth.token,
          password: this.password.value,
          password_confirmation: this.password_confirmation.value,
        })
        .then((res) => {
          this.$emit('close');
          this.$buefy.toast.open({
            message: res.data.message,
            type: 'is-success',
          });
        })
        .catch((err) => {
          this.showErrors(err.response.data.errors);
        });
      this.loading = false;
    },
  },
};
</script>
