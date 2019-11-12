<h3>Pick Date Range</h3>
<p>Choose the dates to limit results</p>
<div class="jobs form large-9 medium-8 columns content">
	<?= $this->Form->create("") ?>
	<fieldset>
		<?php
			echo $this->Pretty->calPicker('date_start', 'Start Date');
			echo $this->Pretty->calPicker('date_end', 'End Date');
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
	<?= $this->Form->button($this->Pretty->iconView("") . __('View Dates'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>