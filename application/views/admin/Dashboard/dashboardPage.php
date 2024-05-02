<div class="content-wrapper">
	<section class="content">
		<div class="container-fluid">
			<div class="row mt-3">
				    <div class="col-md-12">
				        <?php $this->load->view('admin/SessionMessages'); ?>
				    </div>
              	</div>
			<div class="row">
				<div class="col-12 col-sm-6 col-md-3 mt-2">
					<div class="info-box">
                            <span class="info-box-icon bg-info elevation-1">
                                <i class="fas fa-users"></i>
                            </span>
						<div class="info-box-content">
							<span class="info-box-text">Total Users</span>
							<span class="info-box-number"><?php echo isset($totalUsers) ? count($totalUsers) : ''; ?></span>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fas fa-tag"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Products</span>
                                <span class="info-box-number"><?php echo isset($totalProducts) ? $totalProducts : ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-md-up">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-shopping-cart">
                                </i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Orders</span>
                                <span class="info-box-number"><?php echo isset($totalOrders) ? count($totalOrders) : ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-credit-card"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Sales</span>
                                <span class="info-box-number">$<?php echo isset($totalSales) ? number_format($totalSales, 2) : ''; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="row">
                <div class="col-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Total Sales</h3>
                            <div class="card-tools d-none">
                                {!! Form::button('<i class="fas fa-minus"></i>', [
                                    'type' => 'button',
                                    'class' => 'btn btn-tool',
                                    'data-card-widget' => 'collapse'
                                ]) !!}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <!-- LINE CHART -->
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Total Orders</h3>
                            <div class="card-tools d-none">
                                {!! Form::button('<i class="fas fa-minus"></i>', [
                                    'type' => 'button',
                                    'class' => 'btn btn-tool',
                                    'data-card-widget' => 'collapse'
                                ]) !!}
                            </div>
                        </div>
                        <div class="card-body">
                        <div class="chart">
                                <canvas id="barCharts" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Latest Orders</h3>
                        </div>
                        <div class="card-body">
                            <table id="ordersDasboardTable" class="table table-bordered table-striped datatable-dynamic">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
								</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#dashboard").addClass('active');
	function getMonthName(monthAbbreviation) {
	    var parts = monthAbbreviation.split('-');
	    var monthNumber = parseInt(parts[1]) - 1;
	    var date = new Date(parts[0], monthNumber);
	    var monthName = date.toLocaleString('default', { month: 'short' });

	    return monthName;
	}
    <?php
    $monthlyOrderAmounts = $this->data['totalMonthlySales'];
    $monthlyOrderAmountsJson = json_encode($monthlyOrderAmounts);
    ?>
    var monthlyOrderAmounts = <?php echo $monthlyOrderAmountsJson; ?>;

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
	<?php
    $totalOrdersData = $this->data['totalOrdersData'];
    $order_date = json_encode($totalOrdersData);
    ?>
	var order_date = <?php echo $order_date; ?>;
	console.log(order_date);

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

	 $('.order-info').click(function() {
        $('#orderInfoModal').modal('show');
    });
});
</script>