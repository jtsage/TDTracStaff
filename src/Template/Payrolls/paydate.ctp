<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Pick Pay Date</h3>
	<p class="text-dark">Choose the pay date you are targeting</p>

	<?= $this->Form->create("") ?>
	<fieldset>
		<?php
			echo $this->Datebox->calbox('due_payroll_paid', ["label" => 'Payroll Check Date']);
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
	<?= $this->Form->button($this->HtmlExt->icon("magnify") . __(' View Paydate'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>


<?= $this->Pretty->helpMeStart("Choose Paydate"); ?>
<p>Select a pay (paycheck) date to display</p>
<?= $this->Pretty->helpMeEnd(); ?>
