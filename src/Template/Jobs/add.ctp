<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Add A Job</h3>

	<?= $this->Form->create($job) ?>
	<fieldset>
		<?php
			echo $this->Form->control('name', ["label" => "Name of Job"]);
			echo $this->Form->control('detail', ["label" => "Description of Job"]);
			echo $this->Form->control('category', ["label" => "Job Category", "help" => "Auto-completes with previously used categories for convenience.", "autocomplete" => "new-user-address"]);
			echo $this->Form->control('location', ["label" => "Job Location", "help" => "Presents as a Google Maps link, address preferred", "autocomplete" => "new-user-address"]);
		?><div style="border-bottom: 1px dashed #ccc;" class="mt-4 mb-2"><h5>Job Dates</h5></div><?php
			echo $this->Datebox->calbox('date_start', ["label" => 'Start Date', 'help' => 'Start Date of the job']);
			echo $this->Datebox->calbox('date_end', ["label" => 'End Date', 'help' => 'Ending Date of the job']);
			echo $this->Form->control('time_string', ["label" => "Job Time(s)", "help" => "Freeform times for the job. Limit to 250 characters."]);
		?><div style="border-bottom: 1px dashed #ccc;" class="mt-4 mb-2"><h5>Payroll Dates</h5></div><?php
			echo $this->Datebox->calbox('due_payroll_submitted', ["label" => 'Payroll Due Date', 'help' => 'Last date that emloyees may submit hours for this job']);
			echo $this->Datebox->calbox('due_payroll_paid', ["label" => 'Payroll Check Date', 'data-datebox-theme_cal_-date-high-rec' => 'warning', 'help' => 'Date that the checks will be disbursed for this job']);
		?><div style="border-bottom: 1px dashed #ccc;" class="mt-4 mb-2"><h5>Job Status</h5></div>
			<div class="row">
				<div class="col-md-6">
					<?= $this->Form->input('has_payroll', [
						'data-toggle'   => "toggle",
						'data-width'    => '100%',
						'data-height'   => '36px',
						'data-on'       => __('Job has associated Payroll'),
						'data-off'      => __('Job does not accept Payroll'),
						'data-onstyle'  => 'success',
						'data-offstyle' => 'warning',
						'label'         => ""
					]); ?>
				</div><div class="col-md-6">
					<?= $this->Form->input('has_budget', [
						'data-toggle'   => "toggle",
						'data-width'    => '100%',
						'data-height'   => '36px',
						'data-on'       => __('Job has associated Budget'),
						'data-off'      => __('Job does not accept Budget'),
						'data-onstyle'  => 'success',
						'data-offstyle' => 'warning',
						'label'         => ""
					]); ?>
				</div>
			</div>
		<div style="border-bottom: 1px dashed #ccc;" class="mt-4 mb-2"><h5>Job Notes</h5></div><?php
			echo $this->Form->control('notes', ["rows" => 20]);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("calendar-plus") . __('Add New Job'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<script>

<?php
	$rows = [];
	foreach ( $allCats as $cat ) {
		$rows[] = [ "name" => $cat->category, "id" => $cat->category ];
	}
	echo "allCats = " . json_encode($rows) . ";\n";
	$rows = [];
	foreach ( $allLoc as $cat ) {
		$rows[] = [ "name" => $cat->location, "id" => $cat->location ];
	}
	echo "allLoc = " . json_encode($rows) . ";\n";
?>

	var allCatsB = new Bloodhound({
		datumTokenizer: function (d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		identify: function (obj) { return obj.name; },
		local: allCats
	});

	$('#category').typeahead({
		hint: true,
		highlight: true,
		minLength: 2
	},
	{
		name: 'active',
		display: 'id',
		source: allCatsB,
		templates: {
			header: '<h5 class="text-center">Saved Categories</h5>',
			suggestion: function (data) {
				return '<div>' + data.name + '</div>';
			}
		}
	}
	);

	var allLocB = new Bloodhound({
		datumTokenizer: function (d) { return Bloodhound.tokenizers.whitespace(d.name); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		identify: function (obj) { return obj.name; },
		local: allLoc
	});

	$('#location').typeahead({
		hint: true,
		highlight: true,
		minLength: 2
	},
	{
		name: 'active',
		display: 'id',
		source: allLocB,
		templates: {
			header: '<h5 class="text-center">Saved Locations</h5>',
			suggestion: function (data) {
				return '<div>' + data.name + '</div>';
			}
		}
	}
	);

	$("#date_end-dbox").val("");
	$("#due_payroll_paid-dbox").val("");
	$("#due_payroll_submitted-dbox").val("");

	$("#date_start-dbox").datebox( { 
		closeCallback : "linker",
		closeCallbackArgs :["date_end-dbox"]
	} );

	$("#date_end-dbox").datebox( { 
		closeCallback : "linkerNoOpen",
		closeCallbackArgs :["due_payroll_submitted-dbox"]
	} );

	$("#due_payroll_submitted-dbox").datebox( { 
		closeCallback : "linker",
		closeCallbackArgs :["due_payroll_paid-dbox"]
	} );
</script>


<?= $this->Pretty->helpMeStart("Add Job"); ?>

<p>Use this display to add a new job to the system.</p>

<?= $this->Pretty->helpMeFld("Name", "Job Name"); ?>
<?= $this->Pretty->helpMeFld("Description", "Job Description"); ?>
<?= $this->Pretty->helpMeFld("Category", "Freeform category, will auto-complete from previously used categories"); ?>
<?= $this->Pretty->helpMeFld("Location", "Location of job, full street address preferred to auto-link to a google map"); ?>
<?= $this->Pretty->helpMeFld("Start Date", "Beginning date of the job"); ?>
<?= $this->Pretty->helpMeFld("End Date", "End date of the job - for one day jobs, set the same as start date - cannot be left empty"); ?>
<?= $this->Pretty->helpMeFld("Times", "Freeform description of times.  i.e. '9-11p' or 'Saturday: 1-5p, Sunday: 10a - 2p'"); ?>
<?= $this->Pretty->helpMeFld("Payroll Due Date", "The last date payroll can be submitted for this job"); ?>
<?= $this->Pretty->helpMeFld("Payroll Check Date", "Date checks will be cut for this job - standard pay dates are highlighted"); ?>

<p class="mt-2">Payroll disabled jobs still allow staffing.  They are typically used for special "substitute" or "child job" cases where you want the payroll added to a "master" job. By default, all jobs allow payroll records.</p>

<p>Budget enabled jobs allow adding budget items to be added for that job.  By default, jobs do not have an associated budget</p>
<?= $this->Pretty->helpMeEnd(); ?>
