<template>
  <div class="modal-inner">
    <button type="button" class="delete" @click="$emit('close')" />
    <div class="box is-medium has-text-centered">
      <div class="box-inner">
        <div class="mb-5">
          <h2 class="title is-3 has-text-primary">Confirmar voto</h2>
          <p class="subtitle is-5 has-text-primary">Una vez que envies tu voto, quedará guardado en nuestro sistema</p>
        </div>

        <div class="columns is-multiline is-centered">
          <!-- prettier-ignore -->
          <div
            v-for="(item, i) in voting.selection" :key="item.block_id"
            class="column is-4 is-flex is-flex-direction-column is-justify-content-space-between"
          >
            <!-- 
            //# Block -->
            <h3 class="my-4">
              Bloque:<br />
              <span class="title is-5">{{ getSelectedBlock(item.block_id).name }}</span>
            </h3>
            <!-- 
            //# Plate Regular -->
            <div
              v-if="getSelectedPlate(item.block_id, item.plate_id)"
              class="box has-border-width-2 has-border-success has-background-success-light is-flex-grow-1"
            >
              <figure class="image is-48x48 is-centered mb-3">
                <img class="is-rounded" :src="getSelectedPlate(item.block_id, item.plate_id).logo" />
              </figure>
              <h4 class="mb-4">
                Plancha:<br />
                <span class="title is-5">{{ getSelectedPlate(item.block_id, item.plate_id).name }}</span>
              </h4>
              <div class="candidates mb-2">
                <figure
                  v-for="candidate in getSelectedPlate(item.block_id, item.plate_id).candidates_of_block"
                  :key="candidate.id"
                  class="candidates-item image is-48x48"
                >
                  <img class="is-rounded" :src="candidate.photo" />
                </figure>
              </div>
              <div class="mb-2">
                {{ getSelectedPlate(item.block_id, item.plate_id).candidates_of_block.length }} candidatos
              </div>
              <button class="button is-ghost" @click="editSelection(i)">
                <span class="mr-3">Editar</span>
                <icon icon="chevron-right" />
              </button>
          </div>
          <!--
          //# Plate Blank Vote -->
          <div v-else class="box has-border-width-2 has-border-info has-background-info-light is-flex-grow-1">
            <div class="is-fullheight is-flex is-flex-direction-column is-align-items-center is-justify-content-center">
              <h4 class="title is-5 mt-5 mb-2">Voto en Blanco</h4>
              <button class="button is-ghost" @click="editSelection(i)">
                <span class="mr-3">Editar</span>
                <icon icon="chevron-right" />
              </button>
            </div>
          </div>
        </div>
        </div>

        <div class="mt-5">
          <button class="button is-success" :class="{ 'is-loading': loading }" @click="submit">
            Enviar Voto
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VotingConfirmationModal',
  data() {
    return {
      loading: false,
    };
  },
  computed: {
    blocks() {
      return this.$store.state.blocks;
    },
    user() {
      return this.$store.state.user;
    },
    voting() {
      return this.$store.state.voting;
    },
  },
  methods: {
    getSelectedBlock(selectedBlockId) {
      return this.blocks.find((block) => block.id == selectedBlockId);
    },
    getSelectedPlate(selectedBlockId, selectedPlateId) {
      if (selectedPlateId) {
        const selectedBlock = this.getSelectedBlock(selectedBlockId);
        return selectedBlock.plates.find((plateItem) => plateItem.plate_id == selectedPlateId).plate;
      } else {
        return false;
      }
    },
    editSelection(i) {
      this.$emit('close');
      this.$emit('editSelection', i);
    },
    submit() {
      this.loading = true;
      axios
        .post('/api/vote-results/user-vote', {
          votes: this.voting.selection,
        })
        .then(async () => {
          //# Update user data
          this.$store.dispatch('logged');

          this.loading = false;
          this.$emit('close');
        })
        .catch((err) => {
          this.loading = false;
          console.log(err.response);
        });
    },
  },
};
</script>
