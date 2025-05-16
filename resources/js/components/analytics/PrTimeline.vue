<script setup>
const props = defineProps({
  prdocs: Array,
});

const series = [
  {
    data: props.prdocs,
  },
];
const chartOptions = {
  chart: {
    height: 350,
    type: 'rangeBar',
  },
  plotOptions: {
    bar: {
      horizontal: true,
    },
  },
  xaxis: {
    type: 'datetime',
  },
};
</script>

<template>
  <apexchart
    type="rangeBar"
    height="350"
    :options="chartOptions"
    :series="series"
  />
</template>
