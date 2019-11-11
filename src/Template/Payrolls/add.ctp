<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payroll $payroll
 */
?>
<div class="payrolls form large-9 medium-8 columns content">
	<?= $this->Form->create($payroll) ?>
	<fieldset>
		<legend><?= __('Add Payroll') ?></legend>
		<?php
			$jobHelp = ( $CONFIG['allow-unscheduled-hours'] ) ? "You may add hours to shows you have not been scheduled for" : "";
			$jobHelp = ( (count($jobs) > 1 )? "Please select a show. " : "" ) . $jobHelp;
			echo $this->Form->control('user_id', ['readonly' => 'readonly', 'options' => $users]);
			if ( count($jobs) < 2 ) {
				echo $this->Form->control('job_id', ['help' => $jobHelp, 'readonly' => 'readonly', 'options' => $jobs]);
			} else {
				echo $this->Form->control('job_id', ['help' => $jobHelp, 'options' => $jobs]);
			}

			echo $this->Pretty->datePicker('date_worked', __('Date Worked'));
			
			if ( $CONFIG['require-hours'] ) {
				echo $this->Pretty->clockPicker('time_start', __('Start Time'), '9:00');
				echo $this->Pretty->clockPicker('time_end', __('End Time'),  '16:00');
			} else {
				echo $this->Form->control('hours_worked', ['help' => 'Enter the total number of hours worked as a decimal - i.e. 7.5', 'required' => 'required']);
			}
		?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconAdd("") . __('Add Hours'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<script>
$(document).ready( function() {
	$('#date_worked-dbox').datebox({
		beforeToday: true
	});
});
</script>