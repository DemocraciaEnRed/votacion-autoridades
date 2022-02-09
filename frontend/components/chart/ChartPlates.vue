<template>
  <chart height="500" :options="options" :series="series" />
</template>

<script>
import { darkColor, chartColors, blankColor } from '@/js/helpers';

export default {
  name: 'ChartPlates',
  data() {
    return {
      series: [
        {
          data: [],
        },
      ],
      options: {
        // General
        chart: {
          type: 'bar',
          fontFamily: '"Inter", sans-serif',
          toolbar: {
            show: false,
          },
        },
        colors: [...chartColors],
        states: {
          active: {
            filter: {
              type: 'none',
            },
          },
        },
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
            dataLabels: {
              position: 'top',
            },
          },
        },

        legend: {
          show: false,
        },

        xaxis: {
          categories: [],
          labels: {
            style: {
              fontSize: '14px',
              colors: [...darkColor],
            },
          },
        },

        yaxis: {
          labels: {
            style: {
              colors: [...darkColor],
            },
          },
        },

        dataLabels: {
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: [...darkColor],
          },
        },

        tooltip: {
          followCursor: true,
          x: {
            show: false,
          },
          y: {
            formatter(value) {
              return `${value} votos`;
            },
            title: {},
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
      return this.$store.state.results.chart_plates.categories;
    },
    data() {
      return this.$store.state.results.chart_plates.data;
    },
  },
  methods: {
    setBlankColor() {
      const last = this.categories.length - 1;
      this.options.colors[last] = blankColor;
    },
    setCategories() {
      const last = this.categories.length - 1;
      this.categories.forEach((category, index) => {
        const fullName = [];
        if (index < last) fullName.push('Plancha');
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
      // Set Tooltips
      this.options.tooltip.y.title.formatter = (value, options) => {
        return `${this.categories[options.dataPointIndex]}: `;
      };
    },
    setSeries() {
      this.series[0].data = this.data;
    },
  },
  created() {
    this.setCategories();
    this.setSeries();
    this.setBlankColor();
  },
};
</script>
