<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Pick Date Range</h3>
	<p class="text-dark">Choose the dates to limit results</p>

	<?= $this->Form->create("") ?>
	<fieldset>
		<?php
			echo $this->Datebox->calbox('date_start', ["label" => 'Start Date']);
			echo $this->Datebox->calbox('date_end', ["label" => 'End Date']);
			echo $this->Form->input('unpaid', [
				'type'          => "checkbox",
				'data-toggle'   => "toggle",
				'data-width'    => '100%',
				'data-height'   => '36px',
				'data-on'       => __('Unpaid Payroll Only'),
				'data-off'      => __('All Payroll'),
				'data-onstyle'  => 'success',
				'data-offstyle' => 'info',
				'label'         => ""
			]);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("magnify") . __(' View Dates'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>


<?= $this->Pretty->helpMeStart("Choose Date Range"); ?>
<p>Use this display to choose and inclusive date range of payroll items to display.</p>
<?= $this->Pretty->helpMeEnd(); ?>
