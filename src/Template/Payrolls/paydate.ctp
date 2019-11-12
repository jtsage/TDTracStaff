<h3>Pick Pay Date</h3>
<p>Choose the pay date you are trageting</p>
<div class="jobs form large-9 medium-8 columns content">
	<?= $this->Form->create("") ?>
	<fieldset>
		<?php
			echo $this->Pretty->calPicker('due_payroll_paid', 'Payroll Check Date');
			echo $this->Pretty->check('unpaid', 0, [
				'label-width' => '150',
				'label-text' => __('Unpaid Only'),
				'on-text' => __('YES'),
				'off-text' => __('NO'),
				'on-color' => 'success',
				'off-color' => 'danger'
			]);
		?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconView("") . __('View Paydate'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>