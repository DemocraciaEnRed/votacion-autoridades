<template>
  <main class="pt-4 pt-6-tablet">
    <!--
    //# Navigation -->
    <VotingNavigation ref="VotingNavigation" v-if="!user.vote" @confirm="openConfirmationModal" />

    <div class="section pt-6">
      <div class="container">
        <transition name="fade" mode="out-in">
          <!--
          //# Blocks -->
          <div v-if="!user.vote">
            <!-- prettier-ignore -->
            <VotingBlock
              v-show="blocks[voting.step] == block"
              v-for="block in blocks"
              :key="`VotingBlock${block.id}`"
              ref="VotingBlocks"
              :block="block"
              @update-selection="$refs.VotingNavigation.handler()"
            />
          </div>
          <!--
          //# Sent -->
          <VotingSent v-else />
        </transition>
      </div>
    </div>
  </main>
</template>

<script>
import VotingNavigation from './VotingNavigation';
import VotingBlock from './VotingBlock';
import VotingSent from './VotingSent';

import VotingConfirmationModal from './VotingConfirmationModal';
import VotingExitModal from './VotingExitModal';

export default {
  name: 'Voting',
  components: {
    VotingBlock,
    VotingNavigation,
    VotingSent,
  },
  data() {
    return {
      prevDisabled: true,
      nextDisabled: true,
      confirmVisible: false,
      confirmLoading: false,
    };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    voting() {
      return this.$store.state.voting;
    },
    blocks() {
      return this.$store.state.blocks;
    },
  },
  methods: {
    //# Confirmation Modal
    openConfirmationModal() {
      const _this = this;
      this.$buefy.modal.open({
        parent: this,
        component: VotingConfirmationModal,
        hasModalCard: true,
        trapFocus: true,
        scroll: 'keep',
        width: 'auto',
        events: {
          editSelection(i) {
            _this.voting.step = i;
            _this.$refs.VotingNavigation.handler();
          },
        },
      });
    },
  },
  beforeRouteLeave(to, from, next) {
    if (!this.user.vote) {
      //# Exit Modal
      const _this = this;
      this.$buefy.modal.open({
        parent: this,
        component: VotingExitModal,
        hasModalCard: true,
        trapFocus: true,
        scroll: 'keep',
        width: 'auto',
        events: {
          exit() {
            //# Reset Proccess
            _this.$store.dispatch('resetVoting');
            _this.$refs.VotingBlocks.forEach((block) => {
              block.unselectAll();
            });
            next();
          },
        },
      });
    } else {
      next();
    }
  },
};
</script>
