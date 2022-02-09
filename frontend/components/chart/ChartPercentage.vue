<template>
  <div>
    <div class="is-flex is-justify-content-center my-5">
      <b-field>
        <b-select placeholder="Select a name" v-model="active">
          <option v-for="(block, i) in blocks" :value="i" :key="block.name">Bloque {{ block.name }}</option>
        </b-select>
      </b-field>
    </div>
    <!-- prettier-ignore -->
    <chart
      class="pie-chart"
      height="500"
      :options="options"
      :series="activeBlock.series"
      style="margin-bottom:-20px;"
    />
  </div>
</template>

<script>
import { darkColor, chartColors, blankColor, getContrastColor } from '@/js/helpers';

export default {
  name: 'ChartPercentage',
  data() {
    return {
      active: 0,

      options: {
        // General
        chart: {
          type: 'donut',
          fontFamily: '"Inter", sans-serif',
        },
        states: {
          active: {
            filter: {
              type: 'none',
            },
          },
        },
        colors: [...chartColors],
        plotOptions: {
          pie: {
            expandOnClick: false,
          },
        },

        labels: [],
        legend: {
          position: 'top',
          labels: {
            colors: [...darkColor],
            useSeriesColors: false,
          },
          markers: {
            radius: 999,
            offsetY: -0.5,
          },
          itemMargin: {
            vertical: 10,
            horizontal: 10,
          },
          onItemHover: {
            highlightDataSeries: false,
          },
        },
        stroke: {
          show: false,
        },
        dataLabels: {
          offsetX: 20,
          style: {
            fontSize: '12px',
            colors: [],
          },
          dropShadow: {
            enabled: false,
          },
        },
        tooltip: {
          onDatasetHover: {
            highlightDataSeries: false,
          },
          y: {
            formatter(value) {
              return `${value} votos`;
            },
          },
        },
      },

      //End Data
    };
  },
  computed: {
    labels() {
      return this.$store.state.results.chart_percentage.labels;
    },
    blocks() {
      return this.$store.state.results.chart_percentage.blocks;
    },
    activeBlock() {
      return this.blocks[this.active];
    },
  },
  methods: {
    setLabelColors() {
      // Contrast Color
      chartColors.forEach((colors) => {
        const contrastColor = getContrastColor(colors);
        this.options.dataLabels.style.colors.push(contrastColor);
      });
      // Blank Color
      const last = this.labels.length - 1;
      this.options.colors[last] = blankColor;
      this.options.dataLabels.style.colors[last] = darkColor;
    },
    setLables() {
      this.options.labels = this.labels;
      this.setLabelColors();
    },
  },
  created() {
    this.setLables();
  },
};
</script>
