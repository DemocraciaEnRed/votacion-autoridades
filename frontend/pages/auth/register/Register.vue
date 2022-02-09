<template>
  <div class="section">
    <div class="container">
      <!-- prettier-ignore -->
      <RegisterNavigation
        ref="RegisterNavigation"
        v-if="auth.register_step < 2"
        @data-submit="dataSubmit"
        @images-submit="imagesSubmit"
        @images-go-back="imagesGoBack"
      />

      <transition name="fade" mode="out-in">
        <RegisterData ref="RegisterData" v-if="auth.register_step == 0" />
        <RegisterImages ref="RegisterImages" v-if="auth.register_step == 1" />
        <RegisterSent v-if="auth.register_step == 2" />
      </transition>
    </div>
  </div>
</template>

<script>
import RegisterNavigation from './RegisterNavigation';
import RegisterData from './RegisterData';
import RegisterImages from './RegisterImages';
import RegisterSent from './RegisterSent';

export default {
  name: 'Register',
  components: {
    RegisterNavigation,
    RegisterData,
    RegisterImages,
    RegisterSent,
  },
  computed: {
    auth() {
      return this.$store.state.auth;
    },
  },
  methods: {
    //# Data Submit
    async dataSubmit() {
      this.$refs.RegisterNavigation.dataBtnLoading = true;
      this.$refs.RegisterData.cleanErrors();
      await axios
        .post('/api/auth/valid-data-registration', {
          dni: this.auth.form.dni,
          name: this.auth.form.name,
          last_name: this.auth.form.last_name,
          email: this.auth.form.email,
          email_confirmation: this.auth.form.email_confirmation,
          password: this.auth.form.password,
          password_confirmation: this.auth.form.password_confirmation,
        })
        .then(() => {
          this.auth.register_step = 1; //# 1.RegisterImages
        })
        .catch((err) => {
          const res = err.response;
          if (res.status == 422) this.$refs.RegisterData.showErrors(res.data.errors);
        });
      this.$refs.RegisterNavigation.dataBtnLoading = false;
    },

    //# Images Submit
    async imagesSubmit() {
      this.$refs.RegisterNavigation.imagesBtnLoading = true;

      const formData = new FormData();
      formData.append('dni', this.auth.form.dni);
      formData.append('name', this.auth.form.name);
      formData.append('last_name', this.auth.form.last_name);
      formData.append('email', this.auth.form.email);
      formData.append('email_confirmation', this.auth.form.email_confirmation);
      formData.append('password', this.auth.form.password);
      formData.append('password_confirmation', this.auth.form.password_confirmation);
      formData.append('photos[]', this.auth.form.images.front);
      formData.append('photos[]', this.auth.form.images.back);

      //# Register
      await axios
        .post(`/api/auth/register`, formData, {
          header: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then(() => {
          this.$store.dispatch('resetCredentials');
          this.auth.register_step = 2; //# 2.RegisterSent
        });

      this.$refs.RegisterNavigation.imagesBtnLoading = false;
    },

    //# Images Go Back
    imagesGoBack() {
      this.$store.dispatch('resetCredentials');
      this.auth.register_step = 0; //# 0.RegisterData
    },
  },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      if (!vm.auth.valid_dni) vm.$router.push({ name: 'roll-check' });
    });
  },
  beforeRouteLeave(to, from, next) {
    if (to.name != 'roll-check') this.$store.dispatch('resetAuth');
    next();
  },
};
</script>
