<template>
	<div class="ActivityGraph__Weaper">
		<p>test</p>

		<line-chart></line-chart>
	</div>
</template>

<script>
	import LineChart from './components/ActivityGraph/LineChart.js';
	export default{
		components: {
			'line-chart': LineChart
		}
	}
</script>