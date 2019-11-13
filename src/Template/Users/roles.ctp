<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4"><?= h($user->first) . " " . h($user->last) ?> - Asssigned Job Titles</h3>


<?= $this->Form->create(""); ?>

<div style="border-bottom: 1px dashed #ccc" class="row mb-3">

<?php $lastHundy = 0; ?>
<?php foreach ($roles as $role): ?>
	<?php if ( floor($role->sort_order / 100 ) <> $lastHundy ): ?>
		<?php $lastHundy = floor($role->sort_order / 100); ?>
		</div><div style="border-bottom: 1px dashed #ccc" class="row mb-3">
	<?php endif; ?>
	
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-5"><?= $role->title ?></div>
			<div class="col-md-7">
				<?= $this->Form->input('role[]', [
					'hiddenField'   => false,
					'value'         => $role->id,
					'type'          => 'checkbox',
					'checked'       => in_array($role->id, $current),
					'data-toggle'   => "toggle",
					'data-width'    => '100%',
					'data-height'   => '36px',
					'data-on'       => __('Qualified'),
					'data-off'      => __('Do Not Schedule'),
					'data-onstyle'  => 'success',
					'data-offstyle' => 'warning',
					'label'         => ""
				]); ?>
			</div>
		</div>
	</div>

<?php endforeach; ?>

</div>
	</div>

<?= $this->Form->button($this->HtmlExt->icon("account-check") . " Assign Titles", ["class" => "w-100 btn-lg btn-outline-success"]); ?>
<?= $this->Form->end(); ?>

<?= $this->Pretty->helpMeStart("User Roles"); ?>
<p>This section allows you to set which job titles a user is "qualified" for - this controls what job
offers they will see, and which job e-mails they will receive.</p>
<?= $this->Pretty->helpMeEnd(); ?>
