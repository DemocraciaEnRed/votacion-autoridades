<template>
  <div>
    <!--
    //# Top -->
    <section class="section has-text-centered pt-5 pb-0">
      <div class="container">
        <h2 class="tag is-primary-alt is-large mb-3">Resultados</h2>
      </div>
    </section>
    <!--
    //# Hero -->
    <section class="section pt-6" id="datos-de-participacion">
      <div class="container">
        <h2 class="title is-2 has-text-centered">Datos de participación</h2>
        <hr class="hr-title" />
        <div class="level is-results">
          <div class="level-item">
            <h3 class="label">Censo</h3>
            <p class="has-text-primary has-text-centered">
              <span class="value"> {{ results.rolls.length }} </span><br />
              <span class="label is-large">censados</span>
            </p>
          </div>
          <div class="level-item">
            <h3 class="label">Votantes</h3>
            <p class="has-text-primary has-text-centered">
              <span class="value"> {{ results.total_votes }} </span><br />
              <span class="label is-large">votantes</span>
            </p>
          </div>
          <div class="level-item">
            <h3 class="label">% Participación</h3>
            <p class="has-text-primary has-text-centered">
              <span class="value"> {{ results.percentage_voted.toFixed(2) }}% </span><br />
              <span class="label is-large">votaron</span>
            </p>
          </div>
        </div>
      </div>
    </section>
    <!--
    //# Positions -->
    <section class="section" id="designacion-de-cargos">
      <div class="container">
        <h2 class="title is-2 has-text-centered">Designación de cargos</h2>
        <hr class="hr-title" />
        <div class="columns is-multiline is-centered">
          <!-- prettier-ignore -->
          <div
            v-for="block in designations"
            :key="block.id"
            class="column is-3-widescreen is-4-desktop is-6-tablet"
          >
            <div class="box is-fullheight py-6">
              <!-- Block -->
              <h3 class="mb-55 has-text-centered">
                Bloque:<br />
                <span class="title is-5">{{ block.name }}</span>
              </h3>
              <!-- Candidates -->
              <div class="columns is-multiline is-mobile is-centered">
                <div v-for="designation in block.designations" :key="designation.id" class="column is-6-mobile is-full-tablet">
                  <Candidate :candidate="designation.candidate" :plate="designation.candidate.plate" style="max-width:15rem;margin-left:auto;margin-right:auto;"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--
    //# Charts -->
    <section class="section" id="resultados-de-votacion">
      <div class="container">
        <h2 class="title is-2 has-text-centered">Resultados de votación</h2>
        <hr class="hr-title" />
        <div class="box pt-6">
          <h3 class="title is-4 has-text-centered mb-4">
            Cantidad de votos totales por plancha según bloque
          </h3>
          <ChartBlocks />
        </div>
        <div class="box pt-6">
          <h3 class="title is-4 has-text-centered mb-4">
            Representación en porcentajes
          </h3>
          <ChartPercentage />
        </div>
        <div class="box pt-6">
          <h3 class="title is-4 has-text-centered mb-4">
            Resultados por plancha candidata
          </h3>
          <p class="has-text-centered mb-0">
            En total se registraron {{ this.results.total_block_votes }}
            <span class="has-tooltip is-small">
              votos
              <b-tooltip type="is-white" position="is-right" size="is-large" multilined>
                <icon icon="question" />
                <template v-slot:content>
                  <p>El presente conteo de votos representa la <strong>sumatoria de todos los votos realizados a cada plancha dentro de cada bloque.</strong></p>
                </template>
              </b-tooltip>
            </span>
          </p>
          <ChartPlates />
        </div>
        <div class="has-text-centered mt-6">
          <a :href="resultsExcel.file" :download="`${resultsExcel.filename}.xlsx`" class="button is-primary">
            <icon icon="download" class="mr-2" />
            Descargar Excel
          </a>
        </div>
      </div>
    </section>
    <!--
    //# Info Extra -->
    <!-- prettier-ignore -->
    <section 
      v-if="extraInformation.extra_information"
      class="section has-background-info-light has-text-centered"
      id="informacion-extra"
    >
      <div class="container">
        <h2 class="title is-2">Información extra</h2>
        <hr class="hr-title" />
        <div v-html="extraInformation.extra_information" class="is-size-5"></div>
        <a v-if="extraInformation.file" :href="extraInformation.file" :download="`${extraInformation.filename}.pdf`" class="button is-primary mt-6">
          <icon icon="download" class="mr-2" />
          {{ extraInformation.filename }}
        </a>
      </div>
    </section>
    <!--
    //# Plates -->
    <section class="section has-background-white">
      <div class="container">
        <h2 class="title is-2 has-text-centered">Planchas candidatas</h2>
        <hr class="hr-title" />
        <div class="columns is-multiline is-centered">
          <Plate v-for="plate in plates" :key="`plate${plate.id}`" :plate="plate" />
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Timer from '@/components/Timer';
import Candidate from '@/components/Candidate';
import ChartBlocks from '@/components/chart/ChartBlocks';
import ChartPercentage from '@/components/chart/ChartPercentage';
import ChartPlates from '@/components/chart/ChartPlates';
import Plate from '@/components/plate/Plate';

export default {
  name: 'HomeResults',
  components: {
    Timer,
    Candidate,
    ChartBlocks,
    ChartPercentage,
    ChartPlates,
    Plate,
  },
  data() {
    return {
      extraInformation: {
        extra_information: null,
        file: null,
        filename: null,
      },
      resultsExcel: {
        file: null,
        filename: 'Resultados',
      },
    };
  },
  computed: {
    plates() {
      return this.$store.state.plates;
    },
    results() {
      return this.$store.state.results;
    },
    designations() {
      return this.$store.state.designations;
    },
  },
  methods: {
    getCandidatePlate(id) {
      return this.plates.find((plate) => plate.id == id);
    },
    getExtraInformation() {
      axios.get('/api/homes').then((res) => {
        this.extraInformation.extra_information = res.data.extra_information;
        this.extraInformation.file = res.data.file;
        this.extraInformation.filename = res.data.filename;
      });
    },
    getResultsExcel() {
      axios.get('/api/vote-results/excel-results').then((res) => {
        this.resultsExcel.file = res.data.file;
      });
    },
  },
  mounted() {
    this.getExtraInformation();
    this.getResultsExcel();
  },
};
</script>
