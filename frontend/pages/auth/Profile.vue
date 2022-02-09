<template>
  <main class="section pt-4 pt-6-tablet">
    <div class="container">
      <div class="box is-medium">
        <div class="box-inner">
          <h2 class="title is-4">Mi Perfil</h2>
          <hr />
          <div class="columns">
            <div class="column is-half">
              <h3 class="subtitle">Datos de la cuenta</h3>
              <b-field label="Email">
                <b-input :value="user.email" disabled></b-input>
              </b-field>
              <b-field label="Nombre y Apellido">
                <b-input :value="`${user.name} ${user.last_name}`" disabled></b-input>
              </b-field>
              <b-field label="Documento">
                <b-input :value="user.dni | dniFormat" disabled></b-input>
              </b-field>
            </div>
          </div>
          <hr />
          <div class="columns">
            <div class="column is-6-tablet">
              <h3 class="subtitle">Frente del documento</h3>
              <div class="upload">
                <div class="upload-draggable" style="cursor:not-allowed;">
                  <img class="upload-preview" :src="user.photos[0].filename" alt="Frente del documento" />
                </div>
              </div>
            </div>
            <div class="column is-6-tablet">
              <h3 class="subtitle">Dorso del documento</h3>
              <div class="upload">
                <div class="upload-draggable" style="cursor:not-allowed;">
                  <img class="upload-preview" :src="user.photos[1].filename" alt="Dorso del documento" />
                </div>
              </div>
            </div>
          </div>
          <hr />
          <div class="columns">
            <div class="column is-half">
              <h2 class="subtitle">Cambiar Contraseña</h2>
              <form @submit.prevent="submit">
                <b-field label="Actual" :type="actual_password.type" :message="actual_password.message">
                  <b-input v-model="actual_password.value" type="password" password-reveal></b-input>
                </b-field>
                <b-field label="Nueva" :type="password.type" :message="password.message" class="mb-5">
                  <b-input v-model="password.value" type="password" password-reveal></b-input>
                </b-field>
                <b-field label="Confirmar Nueva" :type="password.type" class="mb-5">
                  <b-input v-model="password_confirmation.value" type="password" password-reveal></b-input>
                </b-field>
                <!-- prettier-ignore -->
                <button
                  class="button is-primary is-fullwidth"
                  :class="{ 'is-loading': loading }"
                  :disabled="submitDisabled"
                  type="submit"
                >
                  Cambiar Contraseña
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'Profile',
  data() {
    return {
      loading: false,
      actual_password: {
        value: '',
        type: '',
        message: '',
      },
      password: {
        value: '',
        type: '',
        message: '',
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
    submitDisabled() {
      if (this.password.value && this.password_confirmation.value) return false;
      else return true;
    },
  },
  filters: {
    dniFormat(dni) {
      return Number(dni).toLocaleString('es');
    },
  },
  methods: {
    cleanErrors() {
      this.password.type = '';
      this.password.message = '';
      this.actual_password.type = '';
      this.actual_password.message = '';
    },
    showErrors(errors) {
      if (errors.actual_password) {
        this.actual_password.type = 'is-danger';
        this.actual_password.message = errors.actual_password;
      }
      if (errors.password) {
        this.password.type = 'is-danger';
        this.password.message = errors.password;
      }
    },
    async submit() {
      this.loading = true;
      this.cleanErrors();

      await axios
        .post('/api/change-password', {
          actual_password: this.actual_password.value,
          password: this.password.value,
          password_confirmation: this.password_confirmation.value,
        })
        .then((res) => {
          this.actual_password.value = '';
          this.password.value = '';
          this.password_confirmation.value = '';
          this.$buefy.toast.open({
            message: res.data.message,
            type: 'is-success',
          });
        })
        .catch((err) => {
          const res = err.response;
          if (res.status == 422) this.showErrors(res.data.errors);
        });

      this.loading = false;
    },
  },
};
</script>
