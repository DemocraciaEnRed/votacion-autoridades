<template>
  <div class="modal-inner">
    <button type="button" class="delete" @click="$emit('close')" />
    <div class="box is-small has-text-centered">
      <div class="box-inner">
        <h1 class="title has-text-primary is-4 mb-6">
          ¿Olvidaste tu contraseña?
        </h1>
        <h2 class="subtitle mb-6">
          Ingresa tu email y te enviaremos un link para que puedas reestablecerla
        </h2>
        <form @submit.prevent="submit">
          <b-field label="Email" :type="email.type" :message="email.message">
            <b-input v-model="email.value" />
          </b-field>
          <!-- prettier-ignore -->
          <button
            class="button is-primary is-fullwidth mb-5"
            :class="{ 'is-loading': loading }"
            :disabled="submitDisabled"
            type="submit"
          >
            Enviar
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EmailVerificationModal',
  data() {
    return {
      loading: false,
      email: {
        value: '',
        type: '',
        message: [],
      },
    };
  },
  computed: {
    submitDisabled() {
      return this.email.value == '' ? true : false;
    },
  },
  methods: {
    cleanErrors() {
      this.email.type = '';
      this.email.message = [];
    },
    showErrors(errors) {
      this.email.type = 'is-danger';
      this.email.message = errors.email;
    },

    //# Forgot Password
    async submit() {
      this.loading = true;
      this.cleanErrors();
      await axios
        .post('/api/auth/forgot-password', {
          email: this.email.value,
        })
        .then(() => {
          this.$emit('close');
          this.email.value = '';
        })
        .catch((err) => {
          this.showErrors(err.response.data.errors);
        });
      this.loading = false;
    },
  },
};
</script>
