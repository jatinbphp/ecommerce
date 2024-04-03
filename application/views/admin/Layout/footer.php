	<footer class="main-footer">
		All Rights
	</footer>
</div>
<script src="<?php echo base_url('public/assets/admin/dist/js/adminJqueryValidation.js') ?>"></script>

<!-- DataTables -->
<script src="<?php echo base_url('public/assets/admin/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>

<!-- <script src="<?php echo base_url('public/assets/admin/plugins/jquery/jquery.min.js'); ?>"></script> -->
<script src="<?php echo base_url('public/assets/admin/dist/js/jquery.validate.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/adminlte.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/chart.js/Chart.min.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/demo.js'); ?>"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<!-- <script type="text/javascript">
		// Total Sales Chart

		function getMonthName(monthAbbreviation) {
			var parts = monthAbbreviation.split('-');
			var monthNumber = parseInt(parts[1]) - 1;
			var date = new Date(parts[0], monthNumber);
			var monthName = date.toLocaleString('default', { month: 'short' });

			return monthName;
		}

		var monthlyOrderAmounts = {!! json_encode($monthlyOrderAmounts) !!};

		var chartData = monthlyOrderAmounts.reduce(function(acc, item) {
			acc.labels.push(getMonthName(item.month));
			acc.data.push(item.total_amount);
			return acc;
		}, { labels: [], data: [] });

		var labels = chartData.labels;
		var data = chartData.data;

		var areaChartData = {
			labels  : labels,
			datasets: [
				{
					label               : 'Total Sales',
					backgroundColor     : '#343a40',
					borderColor         : '#343a40',
					pointRadius          : false,
					pointColor          : '#3b8bba',
					pointStrokeColor    : 'rgba(60,141,188,1)',
					pointHighlightFill  : '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data                : data
				}
			]
		}

		var barChartCanvas = $('#barChart').get(0).getContext('2d');
		var barChartData = $.extend(true, {}, areaChartData);
		barChartData.datasets.splice(1, 1);

		var barChartOptions = {
			responsive              : true,
			maintainAspectRatio     : false,
			datasetFill             : false
		};

		new Chart(barChartCanvas, {
			type: 'bar',
			data: barChartData,
			options: barChartOptions
		});

		// ---------------------total orders-----------------------
		var labelsOrders = [];
		var dataOrders = [];
		var order_date = {!! json_encode($order_date) !!};

		order_date.forEach(function(item) {
			labelsOrders.push(item.order_date);
			dataOrders.push(item.num_orders);
		});

		var areaChartDataOrders = {
			labels  : labelsOrders,
			datasets: [
				{
					label               : 'Total Orders',
					backgroundColor     : '#343a40',
					borderColor         : '#343a40',
					pointRadius          : false,
					pointColor          : '#3b8bba',
					pointStrokeColor    : 'rgba(60,141,188,1)',
					pointHighlightFill  : '#fff',
					pointHighlightStroke: 'rgba(60,141,188,1)',
					data                : dataOrders
				}
			]
		};

		var barChartCanvasOrders = $('#barCharts').get(0).getContext('2d');
		var barChartDataOrders = $.extend(true, {}, areaChartDataOrders);

		barChartDataOrders.datasets.splice(1, 1);

		var ordersChartOptions = {
			responsive: true,
			maintainAspectRatio: false,
			datasetFill: false
		};

		new Chart(barChartCanvasOrders, {
			type: 'line',
			data: barChartDataOrders,
			options: ordersChartOptions
		});
	</script> -->
</body>
</html>
