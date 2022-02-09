<template>
  <div>
    <!--
    //# Top -->
    <section class="section has-text-centered pt-5 pb-0">
      <div class="container">
        <h2 class="tag is-info is-large mb-3">Proceso de inscripción</h2>
        <Timer :finish="voting.data.day_close_inscriptions" />
      </div>
    </section>
    <!--
    //# Hero -->
    <section class="section has-background-white pt-8">
      <div class="container">
        <div class="columns is-align-items-center">
          <div class="column">
            <h2 class="title is-1 mb-6">
              <span class="has-text-weight-normal">Elecciones</span><br />
              Juntas de Acción Comunal
            </h2>
            <p class="mb-5-touch">
              <span class="title has-text-weight-normal is-3 has-text-primary">El día de la votación es:</span><br />
              <span class="title has-text-weight-normal is-2">{{ votingDate }}</span>
            </p>
          </div>
          <div class="column is-5 has-text-centered has-text-right-desktop">
            <div class="iframe-wrapper">
              <youtube video-id="8G45uUDuBtk" />
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
    <!--
    //# Can Vote -->
    <RowCanVote v-if="!user.email" />
  </div>
</template>

<script>
import moment from 'moment';
moment.locale('es');

import Timer from '@/components/Timer';
import RowRegister from '@/components/RowRegister';
import RowBlocks from '@/components/RowBlocks';
import RowPlates from '@/components/RowPlates';
import RowHowTo from '@/components/RowHowTo';
import RowCanVote from '@/components/RowCanVote';

export default {
  name: 'HomePreVoting',
  components: {
    Timer,
    RowRegister,
    RowBlocks,
    RowPlates,
    RowHowTo,
    RowCanVote,
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    voting() {
      return this.$store.state.voting;
    },
    votingDate() {
      const dateRaw = this.voting.data.day_start.split(' ')[0];
      const day = moment(dateRaw).format('D');
      const month = moment(dateRaw).format('MMMM');
      const year = moment(dateRaw).format('YYYY');
      return `${day} de ${month} ${year}`;
    },
  },
};
</script>
