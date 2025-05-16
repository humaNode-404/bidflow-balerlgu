<script setup>
import AnalyticsCongratulations from '@/views/dashboard/AnalyticsCongratulations.vue';
import AnalyticsFinanceTab from '@/views/dashboard/AnalyticsFinanceTab.vue';
import AnalyticsOrderStatistics from '@/views/dashboard/AnalyticsOrderStatistics.vue';
import AnalyticsProfitReport from '@/views/dashboard/AnalyticsProfitReport.vue';
import AnalyticsRevenue from '@/views/dashboard/AnalyticsRevenue.vue';
import AnalyticsTotalRevenue from '@/views/dashboard/AnalyticsTotalRevenue.vue';
import AnalyticsTransactions from '@/views/dashboard/AnalyticsTransactions.vue';

defineProps({
  prdocs: Object,
  prtrends: Object,
});
</script>

<template>
  <PrTimeline :prdocs="prdocs" />
  <PrTrends />
  <AnalyticsCongratulations />
  <AnalyticsProfitReport />
  <AnalyticsFinanceTab />
  <AnalyticsOrderStatistics />
  <AnalyticsTotalRevenue />
  <AnalyticsRevenue />
  <AnalyticsTransactions />
</template>
