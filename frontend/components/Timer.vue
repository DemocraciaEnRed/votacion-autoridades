<template>
  <p>
    <span class="is-block subtitle mb-3">{{ text }}</span>
    <span class="level is-mobile is-timer" :class="size">
      <span class="level-item">
        <span class="value" :class="size">{{ days }}</span>
        <span class="label" :class="size">Días</span>
      </span>
      <span class="level-item">
        <span class="value" :class="size">{{ hours }}</span>
        <span class="label" :class="size">Horas</span>
      </span>
      <span class="level-item">
        <span class="value" :class="size">{{ minutes }}</span>
        <span class="label" :class="size">Minutos</span>
      </span>
    </span>
  </p>
</template>

<script>
import moment from 'moment';
moment.locale('es');

export default {
  name: 'Timer',
  props: {
    text: {
      type: String,
      default: 'disponible por',
    },
    size: String,
    finish: String,
  },
  data() {
    return {
      days: '',
      hours: '',
      minutes: '',
      seconds: '',
    };
  },
  methods: {
    startCountDown() {
      if (this.seconds > 0) {
        this.seconds--;
      } else if (this.minutes > 0) {
        this.seconds = 59;
        this.minutes--;
      } else if (this.hours > 0) {
        this.minutes = 59;
        this.hours--;
      } else if (this.days > 0) {
        this.hours = 23;
        this.days--;
      } else {
        clearInterval(this.startCountDown);
      }
    },
    setCountDown() {
      //     this.tag.text = 'Conteo de votos';
      //     this.tag.class = 'is-primary';

      //     this.tag.text = 'Resultados';
      //     this.tag.class = 'is-primary-alt';

      const now = new Date();
      const duration = moment.duration({ from: now, to: moment(this.finish) });
      this.days = Math.floor(duration.asDays());
      this.hours = duration.hours();
      this.minutes = duration.minutes();
      this.seconds = duration.seconds();
      setInterval(this.startCountDown, 1000); // 1 second Intervals
    },
  },
  created() {
    this.setCountDown();
  },
  beforeRouteLeave(to, from, next) {
    clearInterval(this.startCountDown);
    next();
  },
};
</script>
