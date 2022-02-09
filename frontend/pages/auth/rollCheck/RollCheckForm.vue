<template>
  <div>
    <div class="box is-small">
      <div class="box-inner">
        <h1 class="title has-text-primary is-4 mb-6">
          Primero necesitamos verificar si está en el censo
        </h1>
        <h2 class="subtitle mb-6">
          Ingresa tu número de identificación
        </h2>
        <form @submit.prevent="submit">
          <b-field label="Nro de Documento" :type="dni.type" :message="dni.message" class="mb-5">
            <b-input v-model="auth.form.dni" type="number" custom-class="no-arrows"></b-input>
          </b-field>
          <!-- prettier-ignore -->
          <button
        class="button is-primary is-fullwidth"
        :class="{ 'is-loading': loading }"
        :disabled="auth.form.dni.length > 5 ? false : true"
        type="submit"
      >
        Verificar
      </button>
        </form>
      </div>
    </div>
    <p class="is-size-5">
      Ya estoy registrado,<br class="is-visible-mobile" />
      quiero <router-link :to="{ name: 'login' }" class="link">iniciar sesión</router-link>
    </p>
  </div>
</template>

<script>
export default {
  name: 'RollCheckForm',
  data() {
    return {
      loading: false,
      dni: {
        value: '',
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
      this.dni.type = '';
      this.dni.message = '';
    },
    showErrors(data) {
      this.dni.type = 'is-danger';
      this.dni.message = data.message;
    },
    async submit() {
      this.loading = true;
      this.cleanErrors();

      await axios
        .post('/api/auth/valid-dni', {
          dni: this.auth.form.dni,
        })
        .then(() => {
          this.auth.valid_dni = true;
          this.auth.roll_check_step = 1; //# 1.RollCheckRolled
        })
        .catch((err) => {
          this.auth.valid_dni = false;
          const res = err.response;
          if (res.status == 409) {
            this.auth.roll_check_step = 2; //# 2.RollCheckRegistered
          } else if (res.status == 404) {
            this.$router.push({ name: 'roll-request' });
          }
        });

      this.loading = false;
    },
  },
};
</script>
