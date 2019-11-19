<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payroll $payroll
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Edit Payroll</h3>

	<?= $this->Form->create($payroll) ?>
	<fieldset>
		<legend><?= __('Edit Payroll') ?></legend>
		<?php
			echo $this->Form->control('user_id', ['readonly' => 'readonly', 'options' => $users]);
			echo $this->Form->control('job_id', ['readonly' => 'readonly', 'options' => $jobs]);


			echo $this->Datebox->calbox('date_worked', ["label" => 'Date Worked']);
			
			if ( $CONFIG['require-hours'] ) {
				echo $this->Datebox->timebox('time_start', ["label" => "Start Time", "value" => "9:00"]);
				echo $this->Datebox->timebox('time_end', ["label" => "End Time", "value" => "16:00"]);
			} else {
				echo $this->Form->control('hours_worked', ['help' => 'Enter the total number of hours worked as a decimal - i.e. 7.5', 'required' => 'required']);
			}

			echo $this->Form->input('is_paid', [
				'data-toggle'   => "toggle",
				'data-width'    => '100%',
				'data-height'   => '36px',
				'data-on'       => __('Has Been Paid'),
				'data-off'      => __('Still Needs Paid'),
				'data-onstyle'  => 'success',
				'data-offstyle' => 'danger',
				'label'         => ""
			]);
			

		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>


<?= $this->Pretty->helpMeStart("Edit Payroll Item"); ?>
<p>Use this display to edit a payroll item.  Only unpaid payroll items can be edited by regular users.</p>
<?= $this->Pretty->helpMeEnd(); ?>
