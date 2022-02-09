<template>
  <header class="section py-4">
    <div class="container">
      <b-navbar :transparent="true">
        <!--
        //# Brand -->
        <template #brand>
          <b-navbar-item tag="router-link" :to="{ name: 'home' }">
            <figure class="image">
              <img src="/img/logo-democracias-cotidianas.png" alt="Democracias Cotidianas" style="width: 125px;" />
            </figure>
          </b-navbar-item>
          <span class="navbar-item">
            <figure class="image">
              <img src="/img/logo-accion-comunal.png" alt="Elecciones" style="width: 210px;" />
            </figure>
          </span>
        </template>

        <!--
        //# End -->
        <template #end>
          <b-navbar-item tag="div" v-if="showGoHomeBtn || showRegisterBtn || showLoginBtn">
            <div class="buttons is-justify-content-center">
              <!--
              //# Not Logged -->
              <router-link v-if="showGoHomeBtn" class="button is-primary is-outlined" :to="{ name: 'home' }">
                Volver al Inicio
              </router-link>
              <router-link v-if="showRegisterBtn" class="button is-primary" :to="{ name: 'roll-check' }">
                Registrarme
              </router-link>
              <router-link v-if="showLoginBtn" class="button is-primary" :to="{ name: 'login' }">
                Iniciar Sesión
              </router-link>
            </div>
          </b-navbar-item>
          <!--
          //# Logged -->
          <b-navbar-dropdown v-if="user.active" :collapsible="true" :arrowless="true">
            <template #label>
              <div class="is-flex is-align-items-center">
                <div class="is-6 mr-2">{{ user.name + ' ' + user.last_name }} - {{ user.dni | dniFormat }}</div>
                <icon icon="chevron-down" />
              </div>
            </template>
            <b-navbar-item tag="router-link" :to="{ name: 'profile' }">
              Mi Perfíl
            </b-navbar-item>
            <b-navbar-item class="has-text-danger" @click="$store.dispatch('logout')">
              Cerrar Sesión
            </b-navbar-item>
          </b-navbar-dropdown>
        </template>
      </b-navbar>
    </div>
  </header>
</template>

<script>
export default {
  name: 'TheHeader',
  computed: {
    user() {
      return this.$store.state.user;
    },
    voting() {
      return this.$store.state.voting;
    },
    //# ShowBtn Validations
    showGoHomeBtn() {
      if (this.$route.name == 'roll-check') return true;
      else if (this.$route.name == 'roll-request') return true;
      else if (this.$route.name == 'register') return true;
      else if (this.$route.name == 'login') return true;
      else return false;
    },
    showRegisterBtn() {
      if (this.user.email) return false;
      else if (this.voting.data.state.id != 1) return false;
      else if (this.$route.name == 'roll-check') return false;
      else if (this.$route.name == 'roll-request') return false;
      else if (this.$route.name == 'register') return false;
      else if (this.$route.name == 'login') return false;
      else return true;
    },
    showLoginBtn() {
      if (this.user.email) return false;
      else if (this.voting.data.state.id < 2) return false;
      else if (this.$route.name == 'login') return false;
      else return true;
    },
  },
  filters: {
    dniFormat(dni) {
      return Number(dni).toLocaleString('es');
    },
  },
};
</script>
