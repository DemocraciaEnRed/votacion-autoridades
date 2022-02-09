<template>
  <chart :height="height" :options="options" :series="series" />
</template>

<script>
import { darkColor, chartColors, blankColor } from '@/js/helpers';

export default {
  name: 'ChartBlocks',
  data() {
    return {
      options: {
        // General
        chart: {
          type: 'bar',
          fontFamily: '"Inter", sans-serif',
          offsetY: 10,
          toolbar: {
            show: false,
          },
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
          bar: {
            horizontal: true,
            dataLabels: {
              position: 'top',
            },
          },
        },

        legend: {
          position: 'top',
          offsetY: -10,
          fontSize: '14px',
          labels: {
            colors: [...darkColor],
            useSeriesColors: false,
          },
          itemMargin: {
            vertical: 10,
            horizontal: 10,
          },
          onItemHover: {
            highlightDataSeries: false,
          },
        },

        xaxis: {
          categories: [],
          position: 'top',
          labels: {
            style: {
              colors: [...darkColor],
            },
          },
        },

        yaxis: {
          labels: {
            style: {
              fontSize: '14px',
              colors: [...darkColor],
            },
          },
        },

        dataLabels: {
          offsetX: 20,
          style: {
            fontSize: '12px',
            colors: [...darkColor],
          },
        },

        tooltip: {
          intersect: true,
          followCursor: true,
          x: {
            show: false,
          },
          y: {
            formatter(value) {
              return `${value} votos`;
            },
          },
          marker: {
            show: false,
          },
        },
      },
    };
  },
  computed: {
    categories() {
      return this.$store.state.results.chart_blocks.categories;
    },
    series() {
      return this.$store.state.results.chart_blocks.series;
    },
    height() {
      return this.series.length * 100;
    },
  },
  methods: {
    setBlankColor() {
      const last = this.series.length - 1;
      this.options.colors[last] = blankColor;
    },
    setCategories() {
      this.categories.forEach((category) => {
        const fullName = ['Bloque'];
        const name = category.split(' ');
        for (let i = 0; i < name.length; i++) {
          if (name[i + 1]?.length <= 3) {
            fullName.push(`${name[i]} ${name[i + 1]}`);
            i++;
          } else {
            fullName.push(name[i]);
          }
        }
        this.options.xaxis.categories.push(fullName);
      });
    },
  },
  created() {
    this.setCategories();
    this.setBlankColor();
  },
};
</script>
