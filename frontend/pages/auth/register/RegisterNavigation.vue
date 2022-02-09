<template>
  <div class="box is-medium has-background-light py-4">
    <div class="box-inner level" style="height: 50px;">
      <div class="level-item level-left">
        <Progress :completedSteps="auth.register_step + 1" :totalSteps="2" />
        <h1 class="title is-4 has-text-primary">
          Registra tus datos para poder votar
        </h1>
      </div>
      <div class="level-item level-right" v-if="auth.register_step < 2">
        <!--
          //# RegisterData -->
        <!-- prettier-ignore -->
        <button
            v-if="auth.register_step == 0"
            class="button is-primary"
            :class="{ 'is-loading': dataBtnLoading }"
            :disabled="dataBtnDisabled"
            @click="$emit('data-submit')"
          >
            Siguiente
          </button>
        <!--
          //# RegisterImages -->
        <div class="buttons" v-if="auth.register_step == 1">
          <button class="button is-primary is-outlined" @click="$emit('images-go-back')">
            Anterior
          </button>
          <!-- prettier-ignore -->
          <button
              class="button is-success"
              :class="{'is-loading': imagesBtnLoading}"
              :disabled="imagesBtnDisabled"
              @click="$emit('images-submit')"
            >
              Completar
            </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Progress from '@/components/Progress';

export default {
  name: 'RegisterNavigation',
  components: {
    Progress,
  },
  data() {
    return {
      dataBtnLoading: false,
      imagesBtnLoading: false,
    };
  },
  computed: {
    auth() {
      return this.$store.state.auth;
    },
    dataBtnDisabled() {
      if (!this.auth.form.name) return true;
      else if (!this.auth.form.last_name) return true;
      else if (!this.auth.form.email) return true;
      else if (!this.auth.form.email_confirmation) return true;
      else if (!this.auth.form.password) return true;
      else if (!this.auth.form.password_confirmation) return true;
      else if (!this.auth.form.agree_terms == true) return true;
      else return false;
    },
    imagesBtnDisabled() {
      if (!this.auth.form.images.front) return true;
      else if (!this.auth.form.images.back) return true;
      else return false;
    },
  },
};
</script>
