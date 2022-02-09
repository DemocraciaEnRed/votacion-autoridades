<template>
  <form class="box is-medium" @submit.prevent="submit">
    <div class="box-inner">
      <h2 class="subtitle has-text-primary mb-6">Ingresa tus datos identificatorios</h2>
      <p class="mb-6">
        Recuerda tener a mano una foto de tu documento de identidad, ya que se te solicitará para el registro.
      </p>
      <div class="columns is-multiline">
        <div class="column is-half">
          <b-field label="Nombre" :type="name.type" :message="name.message">
            <b-input v-model="auth.form.name" />
          </b-field>
        </div>
        <div class="column is-half">
          <b-field label="Apellido" :type="last_name.type" :message="last_name.message">
            <b-input v-model="auth.form.last_name" />
          </b-field>
        </div>
        <div class="column is-half">
          <b-field label="Email" :type="email.type" :message="email.message">
            <b-input v-model="auth.form.email" />
          </b-field>
        </div>
        <div class="column is-half">
          <b-field label="Confirma tu email" :type="email_confirmation.type" :message="email_confirmation.message">
            <b-input v-model="auth.form.email_confirmation" />
          </b-field>
        </div>
        <div class="column is-half">
          <b-field label="Contraseña" :type="password.type" :message="password.message">
            <b-input v-model="auth.form.password" type="password" password-reveal />
          </b-field>
        </div>
        <div class="column is-half">
          <b-field label="Repetir contraseña">
            <b-input v-model="auth.form.password_confirmation" type="password" password-reveal />
          </b-field>
        </div>
        <div class="column is-half">
          <b-field class="mb-0">
            <b-checkbox v-model="auth.form.agree_terms" :type="agree_terms.type" :message="agree_terms.message">
              Acepto los términos y condiciones
            </b-checkbox>
          </b-field>
          <div class="align-checkbox">
            <router-link :to="{ name: 'terms' }" target="_blank" class="link is-size-65">Términos y condiciones para votar</router-link>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  name: 'RegisterData',
  data() {
    return {
      loading: false,
      name: {
        type: '',
        message: '',
      },
      last_name: {
        type: '',
        message: '',
      },
      email: {
        type: '',
        message: '',
      },
      email_confirmation: {
        type: '',
        message: '',
      },
      password: {
        type: '',
        message: [],
      },
      agree_terms: {
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
    //# CleanErrors
    cleanErrors() {
      this.name.type = '';
      this.name.message = '';
      this.last_name.type = '';
      this.last_name.message = '';
      this.email.type = '';
      this.email.message = '';
      this.email_confirmation.type = '';
      this.email_confirmation.message = '';
      this.password.type = '';
      this.password.message = [];
      this.agree_terms.type = '';
      this.agree_terms.message = '';
    },

    //# ShowErrors
    showErrors(errors) {
      if (errors.name) {
        this.name.type = 'is-danger';
        this.name.message = errors.name;
      }
      if (errors.last_name) {
        this.last_name.type = 'is-danger';
        this.last_name.message = errors.last_name;
      }
      if (errors.email) {
        this.email.type = 'is-danger';
        this.email.message = errors.email;
      }
      if (errors.email_confirmation) {
        this.email_confirmation.type = 'is-danger';
        this.email_confirmation.message = errors.email_confirmation;
      }
      if (errors.password) {
        this.password.type = 'is-danger';
        this.password.message = errors.password;
      }
      if (errors.agree_terms) {
        this.agree_terms.type = 'is-danger';
        this.agree_terms.message = errors.agree_terms;
      }
    },
  },
};
</script>
