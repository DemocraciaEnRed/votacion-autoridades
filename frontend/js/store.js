import axios from 'axios';

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    user: {},
    blocks: {},
    plates: {},
    auth: {
      token: null,
      valid_dni: false,
      roll_check_step: 0,
      roll_request_step: 0,
      register_step: 0,
      form: {
        dni: '',
        name: '',
        last_name: '',
        email: '',
        email_confirmation: '',
        password: '',
        password_confirmation: '',

        agree_terms: false,
        images: {
          front: null,
          back: null,
        },
      },
    },
    voting: {
      data: {},
      step: 0,
      selection: [],
    },
    results: {},
    designations: {},
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
  },
  actions: {
    //# Logged (Check if user is logged)
    async logged({ state, commit, dispatch }) {
      await axios
        .get('/api/logged')
        .then((res) => {
          commit('setUser', res.data);
          localStorage.setItem('user', JSON.stringify(res.data));
        })
        .catch((err) => {
          commit('setUser', {});
          localStorage.removeItem('user');
          console.log(err.response.data.message);
        });
    },
    async getData({ state, commit, dispatch }) {
      //# Get Blocks
      await axios
        .get('/api/blocks/with-plates')
        .then((res) => {
          state.blocks = res.data;
          state.blocks.forEach((block) => {
            block.hasSelected = false;
            if (block.plates) {
              block.plates.forEach((plateItem) => {
                if (plateItem.plate) plateItem.plate.selected = false;
              });
            }
          });
        })
        .catch((err) => {
          console.log(err.response);
        });

      //# Get Plates
      await axios
        .get('/api/plates')
        .then((res) => {
          state.plates = res.data;
        })
        .catch((err) => {
          console.log(err.response);
        });

      //# Get Voting
      await axios
        .get('/api/votes/1')
        .then((res) => {
          state.voting.data = res.data;
          localStorage.setItem('vote', JSON.stringify(res.data));
        })
        .catch((err) => {
          console.log(err.response);
        });

      if (state.voting.data.state_id == 4) {
        //# Get Results
        await axios
          .get('api/vote-results/results')
          .then((res) => {
            console.log(res.data);
            state.results = res.data;
          })
          .catch((err) => {
            console.log(err.response);
          });
        //# Get Designations
        await axios
          .get('api/designations')
          .then((res) => {
            state.designations = res.data;
          })
          .catch((err) => {
            console.log(err.response);
          });
      }
    },
    //# Logout
    async logout({ state, commit, dispatch }) {
      await axios
        .post('/api/auth/logout')
        .then(() => {
          dispatch('resetAuth');
          dispatch('resetCredentials');
          dispatch('resetVoting');
          dispatch('logged');
          location.reload();
        })
        .catch((err) => {
          console.log(err.response);
        });
    },

    //# Resets
    resetCredentials({ state, commit, dispatch }) {
      state.auth.password = '';
      state.auth.password_confirmation = '';
    },
    resetAuth({ state, commit, dispatch }) {
      state.auth.valid_dni = false;

      state.auth.roll_check_step = 0; //# 0.RollCheckForm
      state.auth.roll_request_step = 0; //# 0.RollRequestForm
      state.auth.register_step = 0; //# 0.RegisterData

      state.auth.form.dni = '';
      state.auth.form.name = '';
      state.auth.form.last_name = '';
      state.auth.form.email = '';
      state.auth.form.email_confirmation = '';
      dispatch('resetCredentials');
    },
    resetCanVote({ state, commit, dispatch }) {
      state.canVote.step = 0;
      dispatch('resetAuth');
    },
    resetVoting({ state, commit, dispatch }) {
      state.voting.step = 0;
      state.voting.selection = [];
    },
  },
});

export default store;
