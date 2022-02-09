<template>
  <div class="modal-inner">
    <button type="button" class="delete" @click="$emit('close')" />
    <div class="box is-medium">
      <div class="box-inner">
        <figure class="image is-48x48 is-centered mb-3">
          <img class="is-rounded" :src="plate.logo" />
        </figure>
        <h3 class="mb-5 has-text-centered">
          Plancha<br />
          <span class="title is-5">{{ plate.name }}</span>
        </h3>

        <div class="columns is-multiline is-centered">
          <!-- prettier-ignore -->
          <div 
            v-for="block in blocks"
            :key="block.id"
            v-show="getBlockCandidates(block)"
            class="column is-8-tablet is-6-desktop"
          >
            <div class="py-4 px-5 has-border-grey-lighter has-radius-large is-fullheight">
              <h1 class="mb-5 has-text-centered">
                Bloque:<br />
                <span class="title is-5">{{ block.name }}</span>
              </h1>
              <!--
              //# Candidates -->
              <div class="columns is-multiline is-mobile is-justify-content-center is-justify-content-start-tablet">
                <div v-for="candidate in getBlockCandidates(block)" :key="candidate.id" class="column is-6">
                  <Candidate :candidate="candidate" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Candidate from '@/components/Candidate';
export default {
  name: 'PlateModal',
  components: {
    Candidate,
  },
  props: {
    plate: Object,
  },
  computed: {
    blocks() {
      return this.$store.state.blocks;
    },
  },
  methods: {
    getBlockCandidates(block) {
      const plateItem = block.plates.find((plateItem) => plateItem.plate_id == this.plate.id);
      return plateItem?.plate?.candidates_of_block;
    },
  },
};
</script>
