<template>
  <div>
    <!--
    //# Top -->
    <section class="section has-text-centered pt-5 pb-0">
      <div class="container">
        <h2 class="tag is-large mb-3" :class="user.vote ? 'is-dark' : 'is-success'">
          {{ user.vote ? 'Conteo de votos' : 'Votación activa' }}
        </h2>
        <Timer :text="user.vote ? 'comenzará en' : null" :finish="voting.data.day_finish" />
      </div>
    </section>
    <!--
    //# Hero -->
    <section class="section has-background-white pt-8">
      <div class="container">
        <div class="columns gradient-box">
          <div class="column is-8 gradient-box-left">
            <div class="gradient-box-left-inner">
              <h2 class="title is-1">
                Elecciones<br />
                Juntas de Acción Comunal
              </h2>
              <p>
                ¡Bienvenidos y bienvenidas al proceso democrático donde los afiliados de las Juntas de Acción Comunal tienen la posibilidad de elegir a las personas que los representarán durante un período de cuatro años!
              </p>
            </div>
          </div>
          <div class="column is-4 gradient-box-right">
            <div class="is-flex is-flex-direction-column is-justify-content-space-between is-fullheight">
              <p v-if="user.vote">¡Gracias por participar en las elecciones de la Junta de Acción Comunal en Pereira!</p>
              <p v-else>¡Ya puedes participar en las elecciones de la Junta de Acción Comunal en Pereira!</p>
              <router-link v-if="showVotingBtn" :to="{ name: 'voting' }" class="button is-success is-fullwidth">
                Ir a Votar
              </router-link>
              <router-link v-if="showLoginBtn" :to="{ name: 'login' }" class="button is-primary is-fullwidth">
                Iniciar Sesión
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--
    //# Register -->
    <RowRegister v-if="!user.email" />
    <!--
    //# Blocks -->
    <RowBlocks />
    <!--
    //# Plates -->
    <RowPlates />
    <!--
    //# How To -->
    <RowHowTo />
  </div>
</template>

<script>
import Timer from '@/components/Timer';
import RowRegister from '@/components/RowRegister';
import RowBlocks from '@/components/RowBlocks';
import RowPlates from '@/components/RowPlates';
import RowHowTo from '@/components/RowHowTo';
import RowCanVote from '@/components/RowCanVote';

export default {
  name: 'HomeVoting',
  components: {
    Timer,
    RowRegister,
    RowBlocks,
    RowPlates,
    RowHowTo,
    RowCanVote,
  },
  data() {
    return {};
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    voting() {
      return this.$store.state.voting;
    },
    showVotingBtn() {
      if (!this.user.email) return false;
      else if (this.user.vote) return false;
      else return true;
    },
    showLoginBtn() {
      if (this.user.email) return false;
      else if (this.user.vote) return false;
      else return true;
    },
  },
};
</script>
