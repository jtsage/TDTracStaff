<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payroll $payroll
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Add Payroll Record</h3>

	<?= $this->Form->create($payroll) ?>
	<fieldset>
		<?php
			$jobHelp = ( $CONFIG['allow-unscheduled-hours'] ) ? "You may add hours to shows you have not been scheduled for" : "";
			$jobHelp = ( (count($jobs) > 1 )? "Please select a show. " : "" ) . $jobHelp;
			echo $this->Form->control('user_id', ['readonly' => 'readonly', 'options' => $users]);
			if ( count($jobs) < 2 ) {
				echo $this->Form->control('job_id', ['help' => $jobHelp, 'readonly' => 'readonly', 'options' => $jobs]);
			} else {
				echo $this->Form->control('job_id', ['help' => $jobHelp, 'options' => $jobs]);
			}

			echo $this->Datebox->calbox('date_worked', ["label" => 'Date Worked']);
			
			if ( $CONFIG['require-hours'] ) {
				echo $this->Datebox->timebox('time_start', ["label" => "Start Time", "value" => "9:00"]);
				echo $this->Datebox->timebox('time_end', ["label" => "End Time", "value" => "16:00"]);
			} else {
				echo $this->Form->control('hours_worked', ['help' => 'Enter the total number of hours worked as a decimal - i.e. 7.5', 'required' => 'required']);
			}

			echo $this->Form->control('notes', ["label" => "Note", 'help' => 'Additional Required Details for these hours.']);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("account-cash") . __(' Add Hours'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<script>
$(document).ready( function() {
	$('#date_worked-dbox').datebox({
		beforeToday: true
	});
});
</script>


<?= $this->Pretty->helpMeStart("Add Payroll Item"); ?>
<p>Use this display to add payroll items to the database.  Depending on configuration, you must supply either start and end times, or the number of hours worked.</p>
<?= $this->Pretty->helpMeEnd(); ?>
