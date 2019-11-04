<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>
<h3>Edit Existing Job</h3>
<div class="jobs form large-9 medium-8 columns content">
	<?= $this->Form->create($job) ?>
	<fieldset>
		<?php
			echo $this->Form->control('name', ["label" => "Name of Job"]);
			echo $this->Form->control('detail', ["label" => "Description of Job"]);
			echo $this->Form->control('category', ["label" => "Job Category", "help" => "Auto-completes with previously used categories for convenience.", "autocomplete" => "new-user-address"]);
			echo $this->Form->control('location', ["label" => "Job Location", "help" => "Presents as a Google Maps link, address preferred"]);
		?><div style="border-bottom: 1px dashed #ccc;" class="mt-4 mb-2"><h5>Job Dates</h5></div><?php
			echo $this->Pretty->calPicker('date_start', 'Start Date', $job->date_start);
			echo $this->Pretty->calPicker('date_end', 'End Date', $job->date_end);
			echo $this->Form->control('time_string', ["label" => "Job Time(s)", "help" => "Freeform times for the job. Limit to 250 characters."]);
		?><div style="border-bottom: 1px dashed #ccc;" class="mt-4 mb-2"><h5>Payroll Dates</h5></div><?php
			echo $this->Pretty->calPicker('due_payroll_submitted', 'Payroll Due Date (from employees)', $job->due_payroll_submitted);
			echo $this->Pretty->calPicker('due_payroll_paid', 'Payroll Check Date', $job->due_payroll_paid);
		?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconSave("") . __('Save Job'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<script>

<?php
	$rows = [];
	foreach ( $allCats as $cat ) {
		$rows[] = [ "name" => $cat->category, "id" => $cat->category ];
	}
	echo "allCats = " . json_encode($rows) . ";\n";
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

	$("#date_start-dbox").datebox( { 
		closeCallback : "linker",
		closeCallbackArgs :["date_end-dbox"]
	} );

	$("#date_end-dbox").datebox( { 
		closeCallback : "linkerNoOpen",
		closeCallbackArgs :["due_payroll_submitted-dbox"]
	} );

	$("#due_payroll_submitted-dbox").datebox( { 
		closeCallback : "linkerGuessDate",
		closeCallbackArgs :["due_payroll_paid-dbox"]
	} );
</script>


