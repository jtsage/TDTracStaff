<div class="card-deck d-none d-md-flex mb-4">
	<div class="card p-2 bg-light m-2 shadow">
		<div class="card-body bg-transparent text-center text-secondary">
			<i class="mdi mdi-account-multiple"></i> Active Users
		</div><div class="card-footer bg-transparent">
			<div class="h1 text-primary text-right mb-0"><?= number_format($totUser) ?></div>
		</div>
	</div>

	<div class="card p-2 bg-light m-2 shadow">
		<div class="card-body bg-transparent text-center text-secondary">
			<i class="mdi mdi-worker"></i> Active Jobs
		</div><div class="card-footer bg-transparent">
			<div class="h1 text-primary text-right mb-0"><?= number_format($jobCounts->total_active )?></div>
		</div>
	</div>

	<div class="card p-2 bg-light m-2 shadow">
		<div class="card-body bg-transparent text-center text-secondary">
			<i class="mdi mdi-worker"></i> Open Jobs
		</div><div class="card-footer bg-transparent">
			<div class="h1 text-primary text-right mb-0"><?= number_format($jobCounts->total_open) ?></div>
		</div>
	</div>

	<div class="card p-2 bg-light m-2 shadow">
		<div class="card-body bg-transparent text-center text-secondary">
			<i class="mdi mdi-account-star"></i> Active Positions
		</div><div class="card-footer bg-transparent">
			<div class="h1 text-primary text-right mb-0"><?= number_format($availPos) ?></div>
		</div>
	</div>

	<div class="card p-2 bg-light m-2 shadow">
		<div class="card-body bg-transparent text-center text-secondary">
			<i class="mdi mdi-cash"></i> Unpaid Hours
		</div><div class="card-footer bg-transparent">
			<div class="h1 text-primary text-right mb-0"><?= number_format($myPay->total_unpaid,2) ?></div>
		</div>
	</div>
</div>


<div class="card shadow mb-2">
	<div class="card-header bg-transparent h2 text-primary">Hours By Job</div>
	<div class="card-body">
		<div class="w-100">
			<canvas id="hourByJobC"></canvas>
		</div>
		<table class="table table-sm w-100 mt-1 mb-1">
		</table>
		<p class="small mb-0">This shows a breakdown of hours by job. Only open jobs are displayed.</p>
	</div>
	<div class="card-footer bg-transparent">
		<?= $this->HtmlExt->iconBtnLink(
			"cash",
			"Payroll by Job",
			["controller" => "Payrolls", "action" => "byjob", ],
			["class" => "btn w-100 btn-primary"]
		); ?>
	</div>
</div>
<?php 
	$barLabel =   [];
	$dataPaid =   [];
	$dataUnpaid = [];

	foreach ( $jobPayTotal as $job ) {
		$barLabel[] = $job->job->name;
		$dataPaid[] = $job->total_paid;
		$dataUnpaid[] = $job->total_unpaid;
	}
?>
	
<script type="text/javascript">
	var barChartData = {
	labels: <?= json_encode($barLabel) ?>,
	datasets: [{
		label: 'Paid Hours',
		backgroundColor: "rgba(220,220,220,0.5)",
		barThickness : 10,
		data: <?= json_encode( $dataPaid ) ?>
	}, {
		label: 'Un-Paid Hours',
		barThickness : 10,
		backgroundColor: "rgba(82,154,190,0.5)",
		data: <?= json_encode( $dataUnpaid ) ?>
	}]

};

var ctx = document.getElementById("hourByJobC").getContext("2d");
var myBar = new Chart(ctx, {
	type: 'horizontalBar',
	data: barChartData,
	options: {
		title: {
			display: false,
			text: "Chart.js Bar Chart - Stacked"
		},
		tooltips: {
			mode: 'label',
			callbacks: {
				label: function(tooltipItem, data) {
					var corporation = data.datasets[tooltipItem.datasetIndex].label;
					var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
					return corporation + " : " + valor.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
				},
				afterBody: function (tooltipItem, data) {
					  var corporation = data.datasets[tooltipItem[0].datasetIndex].label;
					var valor = data.datasets[tooltipItem[0].datasetIndex].data[tooltipItem[0].index];
					var total = 0;
					for (var i = 0; i < data.datasets.length; i++)
						total += data.datasets[i].data[tooltipItem[0].index];  
				  	return "     Total : " + total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
				}
				
			}
		},
		responsive: true,
		aspectRatio: 3,
		scales: {
			xAxes: [{
				stacked: true,
			}],
			yAxes: [{
				stacked: true
			}]
		}
	}
});

</script>

	
<div class="card shadow mb-2">
	<div class="card-header bg-transparent h2 text-primary">Unpaid Hours by Employee</div>
	<div class="card-body">
		<div class="text-center">
			<canvas id="unpaidUserC"></canvas>
		</div>
		<table class="table table-sm w-100 mt-1 mb-1">
			
		</table>
		<p class="small mb-0">This shows those employees that currently have unpaid hours in the system.</p>
	</div>
	<div class="card-footer bg-transparent">
		<?= $this->HtmlExt->iconBtnLink(
			"cash",
			"View All Unpaid Payroll",
			["controller" => "Payrolls", "action" => "unpaid"],
			["class" => "btn w-100 btn-primary"]
		); ?>
	</div>
</div>

<?php
	$upayData = [];
	$upayLabel = [];

	foreach ( $userPayTotal as $user ) {
		if ( $user->total_unpaid > 0 ) {
			$upayData[] = round($user->total_unpaid,2);
			$upayLabel[] = $user->user->first . " " . $user->user->last;
		}
	}
?>
<script type="text/javascript">
	var config = {
			data: {
				datasets: [{
					data: <?= json_encode($upayData) ?>, 
					backgroundColor: window.lottaColors,
					label: 'Employees' // for legend
				}],
				labels: <?= json_encode($upayLabel) ?>
			},
			options: {
				responsive: true,
				aspectRatio: 3,
				legend: {
					position: 'right',
				},
				title: {
					display: false,
					text: 'Chart.js Polar Area Chart'
				},
				scale: {
					ticks: {
						beginAtZero: true
					},
					reverse: false
				},
				animation: {
					animateRotate: false,
					animateScale: false
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('unpaidUserC');
			window.myPolarArea = Chart.PolarArea(ctx, config);
		};
</script>


<div class="card shadow">
	<div class="card-header bg-transparent h2 text-primary">Staffing Requirements By Job</div>
	<div class="card-body">
		<div class="text-center">
			<canvas id="myAvailC"></canvas>
		</div>
		<table class="table table-sm w-100 mt-1 mb-1">
			
		</table>
		<p class="small mb-0">This shows how many jobs you have indicated your 
		availability for.  It should be completely full, if not, please click the button below.</p>
	</div>
	<div class="card-footer bg-transparent">
		<?= $this->HtmlExt->iconBtnLink(
			"worker",
			"Jobs Awaiting Response",
			["controller" => "Jobs", "action" => "myrespond"],
			["class" => "btn w-100 btn-primary"]
		); ?>
	</div>
</div>
	

<script type="text/javascript">
	
</script>


<?= $this->Pretty->helpMeStart("Dashboard"); ?>

<p>This display shows an overview of your data in the system.</p>


<?= $this->Pretty->helpMeEnd(); ?>