<div class="d-md-none px-1 py-2">
  <?= $this->HtmlExt->iconBtnLink(
	  "account-cash",
	  "Add Payroll Hours",
	  ["controller" => "payrolls", "action" => "add"],
	  ["class" => "btn btn-success btn-lg w-100 shadow-sm"]
  ); ?>
</div>

<div class="card-deck d-none d-md-flex mb-4">
	

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
			<i class="mdi mdi-calendar-check"></i> Scheduled Jobs
		</div><div class="card-footer bg-transparent">
			<div class="h1 text-primary text-right mb-0"><?= number_format($mySched) ?></div>
		</div>
	</div>

	<div class="card p-2 bg-light m-2 shadow">
		<div class="card-body bg-transparent text-center text-secondary">
			<i class="mdi mdi-calendar-star"></i> Need Response
		</div><div class="card-footer bg-transparent">
			<div class="h1 text-primary text-right mb-0"><?= number_format($myPoss-$mySched) ?></div>
		</div>
	</div>

	<div class="card p-2 bg-light m-2 shadow">
		<div class="card-body bg-transparent text-center text-secondary">
			<i class="mdi mdi-account-cash"></i> Unpaid Hours
		</div><div class="card-footer bg-transparent">
			<div class="h1 text-primary text-right mb-0"><?= number_format($myPay->total_unpaid,2) ?></div>
		</div>
	</div>
</div>

<div class="card-deck">
	
	<div class="card shadow">
		<div class="card-header bg-transparent h2 text-primary">Your Unpaid Hours</div>
		<div class="card-body">
			<div class="mx-auto mb-2">
				<canvas id="myPayDonutC" class="mx-auto"></canvas>
			</div>
			<table class="table table-sm w-100 mt-1 mb-1">
				<tr>
					<td class="w-25 text-right" style="background-color:rgba(220,220,220,0.5)"><?= number_format($myPay->total_closed,2) ?></td>
					<td>Hours From Closed Jobs</td>
				</tr>
				<tr class="mt-1">
					<td class="text-right" style="background-color:rgba(151,187,205,0.5)"><?= number_format($myPay->total_open,2) ?></td>
					<td>Hours From Open Jobs</td>
				</tr>
				<tr>
					<td class="text-right" style="background-color:rgba(82,154,190,0.5)"><?= number_format($myPay->total_active,2) ?></td>
					<td>Hours From Active Jobs</td>
				</tr>
			</table>




			<p class=" small mb-0">This shows how many unpaid hours you are owed, along with the 
			job status.  Closed jobs should already have been paid to you.  Open jobs no longer accept 
			new payroll items, and are likely to be disbursed soon.  Active jobs are still accepting 
			hours.</p>
		</div>
		<div class="card-footer bg-transparent">
			<?= $this->HtmlExt->iconBtnLink(
				"cash",
				"My Unpaid Hours",
				["controller" => "Payrolls", "action" => "mine", "unpaid"],
				["class" => "btn w-100 btn-primary"]
			); ?>
		</div>
	</div>
	
	<script type="text/javascript">
		var myPayDonut = document.getElementById("myPayDonutC");
 		if (myPayDonut) {
			 console.log("yeah");
			new Chart(myPayDonut, {
				type: 'doughnut',
				data: {
					datasets: [{
						data: [
							<?= number_format($myPay->total_closed,2) ?>,
							<?= number_format($myPay->total_open,2) ?>,
							<?= number_format($myPay->total_active,2) ?>
						],
						backgroundColor: [
							"rgba(220,220,220,0.5)",
							"rgba(151,187,205,0.5)",
							"rgba(82,154,190,0.5)"
						],
						label: 'UnPaid Hours'
					}],
					labels: [
						'Hours From Closed Jobs',
						'Hours From Open, Inactive Jobs - To Be Disbursed Shortly',
						'Hours From Active Jobs - Still Accepting Hours'
					]
				},
				options: {
					responsive: true,
					legend: {
						position: 'none',
						align: 'end'
					},
					title: {
						display: false,
						text: 'Chart.js Doughnut Chart'
					},
					cutoutPercentage: 60,
					aspectRatio: 3.5,
					animation: {
						duration: 0,
						animateScale: false,
						animateRotate: false
					},
					circumference : Math.PI,
					rotation : -Math.PI,
				}
				
			});
		}
	</script>

	
	<div class="card shadow">
		<div class="card-header bg-transparent h2 text-primary">Your availability</div>
		<div class="card-body">
			<div class="text-center">
				<canvas id="myAvailC"></canvas>
			</div>
			<table class="table table-sm w-100 mt-1 mb-1">
				<tr>
					<td class="w-25 table-success text-right"><?= $mySched ?></td>
					<td>Jobs Responded To</td>
				</tr>
				<tr class="mt-1">
					<td class="text-right"><?= $myPoss - $mySched ?></td>
					<td>Jobs Awaiting Response</td>
				</tr>
			</table>
			<p class=" small mb-0">This shows how many jobs you have indicated your 
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
		var opts = {
			angle: 0.1, // The span of the gauge arc
			lineWidth: 0.3, // The line thickness
			radiusScale: 1, // Relative radius
			pointer: {
				length: 0.6, // // Relative to gauge radius
				strokeWidth: 0.035, // The thickness
				color: '#000000' // Fill color
			},
			limitMax: false,     // If false, max value increases automatically if value > maxValue
			limitMin: false,     // If true, the min value of the gauge will be fixed
			colorStart: '#3CB521',   // Colors
			colorStop: '#9ad98c',    // just experiment with them
			strokeColor: '#E0E0E0',  // to see which ones work best for you
			generateGradient: true,
			highDpiSupport: true,     // High resolution support
		};
		var target = document.getElementById('myAvailC'); // your canvas element
		var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
		gauge.maxValue = <?= $myPoss ?>; // set max gauge value
		gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
		gauge.animationSpeed = 16; // set animation speed (32 is default value)
		gauge.set(<?= $mySched ?>);// set actual value
	</script>
</div>

<?= $this->Pretty->helpMeStart("Dashboard"); ?>

<p>This display shows an overview of your data in the system.</p>


<?= $this->Pretty->helpMeEnd(); ?>