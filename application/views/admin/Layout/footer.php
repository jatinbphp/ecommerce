	<footer class="main-footer">
		All Rights
	</footer>
</div>
<!-- DataTables -->
<script src="<?php echo base_url('public/assets/admin/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/jquery.validate.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/adminlte.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/chart.js/Chart.min.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/demo.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/ladda/spin.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/ladda/ladda.min.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/plugins/summernote/summernote.js') ?>"></script>
<script src="<?php echo base_url('public/assets/admin/dist/js/adminJqueryValidation.js') ?>"></script>
<script type="text/javascript">
	function AjaxUploadImage(obj,id){
        var file = obj.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
        {
            $('#previewing'+URL).attr('src', 'noimage.png');
            alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        } else{
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(obj.files[0]);
        }

        function imageIsLoaded(e){
            $('#DisplayImage').css("display", "block");
            $('#DisplayImage').css("margin-top", "1.5%");
            $('#DisplayImage').attr('src', e.target.result);
            $('#DisplayImage').attr('width', '150');
        }
    }

    $(".description").each(function() {
            var textarea = $(this);
            textarea.summernote({
                height: 250,
                placeholder: textarea.attr('placeholder'),
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize', 'height']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table','picture','link','map','minidiag']],
                    ['misc', ['codeview']],
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        for (var i = 0; i < files.length; i++)
                            upload_image(files[i], this);
                    }
                },
                onInit: function() {
                    var placeholderText = textarea.attr('placeholder');
                    placeholderText = placeholderText.replace(/\n/g, "<br>");
                    textarea.summernote('option', 'placeholder', placeholderText);
                },
                onChange: function(contents) {
                    if (contents.trim() === '') {
                        var placeholderText = textarea.attr('placeholder');
                        placeholderText = placeholderText.replace(/\n/g, "<br>");
                        textarea.summernote('option', 'placeholder', placeholderText);
                    }
                }
            });
        });
</script>

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
