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

<div class="card-deck mb-1 mb-md-4">
	<div class="card shadow">
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
		
	<script>
		var barChartData = {
		labels: <?= json_encode($barLabel) ?>,
		datasets: [{
			label: 'Paid',
			backgroundColor: "rgba(220,220,220,0.5)",
			barThickness : 10,
			data: <?= json_encode( $dataPaid ) ?>
		}, {
			label: 'Un-Paid',
			barThickness : 10,
			backgroundColor: "rgba(82,154,190,0.5)",
			data: <?= json_encode( $dataUnpaid ) ?>
		}]

	};

	var hbC = document.getElementById("hourByJobC").getContext("2d");
	var myBar = new Chart(hbC, {
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
			aspectRatio: 2,
			scales: {
				xAxes: [{
					stacked: true,
					//type: "logarithmic",
					ticks: {
						beginAtZero: true
					},
				}],
				yAxes: [{
					stacked: true
				}]
			}
		}
	});
	</script>

	
	<div class="card shadow">
		<div class="card-header bg-transparent h2 text-primary">Unpaid Hours by Employee</div>
		<div class="card-body">
			<div class="text-center">
				<canvas id="unpaidUserC"></canvas>
			</div>
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
	<script>
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
					aspectRatio: 2,
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

			var upC = document.getElementById('unpaidUserC');
			window.myPolarArea = Chart.PolarArea(upC, config);
			
	</script>
</div>

<div class="card-deck mb-1 mb-md-4">
<div class="card shadow">
	<div class="card-header bg-transparent h2 text-primary">Staffing Requirements By Job</div>
	<div class="card-body">
		<div class="text-center">
			<canvas id="staffChart"></canvas>
		</div>
		<table class="table table-sm w-100 mt-1 mb-1">
			
		</table>
		<p class="small mb-0">This shows an overview of availability and scheduling data for active jobs in the system.</p>
	</div>
	<div class="card-footer bg-transparent">
		<?= $this->HtmlExt->iconBtnLink(
			"worker",
			"Job List",
			["controller" => "Jobs", "action" => "index"],
			["class" => "btn w-100 btn-primary"]
		); ?>
	</div>
</div>

<?php
	$workers_Needed = [];
	$workers_Avail  = [];
	$workers_Sched  = [];
	$workers_Label  = [];
	$workers_Perc   = [];

	foreach ( $jobsObj as $job ) {
		if ( !empty( $job->roles ) ) {
			$needed = 0;
			foreach ( $job->roles as $role ) {
				$needed += $role->_joinData->number_needed;
			}
			$workers_Needed[] = $needed;
			$workers_Avail[]  = count($job->users_int);
			$workers_Sched[]  = count($job->users_sch);
			$workers_Label[]  = $job->name;
			$workers_Perc[]   = intval((count($job->users_sch) / ( $needed > 1 ? $needed : 0 )) * 100);
		}
	}
?>

<script>
	var barChartData = {
		labels: <?= json_encode( $workers_Label ) ?>,
		datasets: [{
			label: 'Needed',
			yAxisID: "y-axis-1",
			type: 'bar',
			backgroundColor: "rgba(220,220,220,0.5)",
			data: <?= json_encode( $workers_Needed ) ?>
		}, {
			label: 'Available',
			yAxisID: "y-axis-1",
			type: 'bar',
			backgroundColor: "rgba(151,187,205,0.5)",
			data: <?= json_encode( $workers_Avail ) ?>
		}, {
			label: 'Scheduled',
			yAxisID: "y-axis-1",
			type: 'bar',
			backgroundColor: "rgba(82,154,190,0.5)",
			data: <?= json_encode( $workers_Sched ) ?>
		}, {
			label: 'Complete %',
			yAxisID: "y-axis-2",
			type: 'line',
			borderColor: "rgba(205,151,187,0.5)",
			borderWidth: 2,
			fill: false,
			data: <?= json_encode( $workers_Perc ) ?>
		}]

	};

	window.onload = function() {
		var ctx = document.getElementById('staffChart').getContext('2d');
		window.myBar = new Chart(ctx, {
			type: 'bar',
			data: barChartData,
			options: {
				aspectRatio: 2,
				responsive: true,
				tooltips: {
					mode: 'index',
					intersect: true
				},
				legend: {
					position: 'top',
				},
				title: {
					display: false,
					text: 'Chart.js Bar Chart'
				},
				scales: {
					xAxes: [{
						ticks: {
							display: false //this will remove only the label
						}
					}],
					yAxes: [{
							type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: "left",
							id: "y-axis-1",
							ticks: {
								beginAtZero: true
							}
						}, {
							type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: "right",
							id: "y-axis-2",

							// grid line settings
							gridLines: {
								drawOnChartArea: false, // only want the grid lines for one axis to show up
							},
							ticks: {
								beginAtZero: true
							}
						}]
				}
			}
		});

	};
</script>

<div class="card shadow">
	<div class="card-header bg-transparent h2 text-primary">Job Cost Estimator</div>
	<div class="card-body">
		<div class="text-center">
			<canvas id="jcostChart"></canvas>
		</div>
		<table class="table table-sm w-100 mt-1 mb-1">
			
		</table>
		<p class="small mb-0">This shows an overview payroll hours and budget amounts in the system.</p>
	</div>
	<div class="card-footer bg-transparent">
		<?= $this->HtmlExt->iconBtnLink(
			"worker",
			"Job List",
			["controller" => "Jobs", "action" => "index"],
			["class" => "btn w-100 btn-primary"]
		); ?>
	</div>
</div>

<?php
	$jobCostList = [
		"label"  => [],
		"hours"  => [],
		"budget" => []
	];

	foreach ( $jobsObj as $thisJob ) {
		$thisCostList = [
			"name"   => $thisJob->name,
			"hours"  => (array_key_exists($thisJob->id, $jobPayTotalArr) ? $jobPayTotalArr[$thisJob->id]->total_worked : 0 ),
			"budget" => (array_key_exists($thisJob->id, $budgeTotal) ? $budgeTotal[$thisJob->id] : 0 )
		];
		if ( $thisCostList["hours"] > 0 || $thisCostList["budget"] > 0 ) {
			$jobCostList["label"][]  = $thisCostList["name"];
			$jobCostList["hours"][]  = $thisCostList["hours"];
			$jobCostList["budget"][] = $thisCostList["budget"];
		}
	}
?>

<script>
	var chartData = {
			labels: <?= json_encode($jobCostList["label"]) ?>,
			datasets: [{
				type: 'bar',
				label: 'Hours',
				backgroundColor: "rgba(151,187,205,0.5)",
				fill: false,
				data: <?= json_encode($jobCostList["hours"]) ?>,
				yAxisID: "y-axis-1"
			}, {
				type: 'line',
				label: 'Budget $',
				borderColor: "rgba(205,151,187,0.5)",
				borderWidth: 2,
				fill: false,
				data: <?= json_encode($jobCostList["budget"]) ?>,
				yAxisID: "y-axis-2"
			}]

		};
		$(document).ready( function() {
			var ctx = document.getElementById('jcostChart').getContext('2d');
			window.myMixedChart = new Chart(ctx, {
				type: 'bar',
				data: chartData,
				options: {
					responsive: true,
					aspectRatio: 2,
					title: {
						display: false,
						text: 'Chart.js Combo Bar Line Chart'
					},
					tooltips: {
						mode: 'index',
						intersect: true
					},
					scales: {
						xAxes: [{
							ticks: {
								display: false //this will remove only the label
							}
						}],
						yAxes: [{
							type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: "left",
							id: "y-axis-1",
							ticks: {
								beginAtZero: true
							}
						}, {
							type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: "right",
							id: "y-axis-2",

							// grid line settings
							gridLines: {
								drawOnChartArea: false, // only want the grid lines for one axis to show up
							},
							ticks: {
								beginAtZero: true
							}
						}],
					}
				}
			});
		});
</script>
</div>



<div class="card shadow mb-2">
	<div class="card-header bg-transparent h2 text-primary">iCalendar (ics) Links</div>
	<div class="card-body">
		<p><strong>Event per Job: </strong><span class="text-info"><?= $CONFIG['server-name'] ?>/icals/jobs/<?= $CONFIG['calendar-api-key'] ?>/jobs.ics</span></p>
		<p><strong>Event per Scheduled Employee: </strong><span class="text-info"><?= $CONFIG['server-name'] ?>/icals/users/<?= $CONFIG['calendar-api-key'] ?>/users.ics</span></p>
	</div>
</div>


<?= $this->Pretty->helpMeStart("Dashboard"); ?>

<p>This display shows an overview of your data in the system.</p>


<?= $this->Pretty->helpMeEnd(); ?>