<div class="users view large-10 medium-9 columns">
	<h3><?= h($user->first) . " " . h($user->last) ?> - Asssigned Job Titles</h3>
</div>

<?= $this->Form->create(""); ?>

<div class="row">

<?php foreach ($roles as $role): ?>
	<div class="col-md-6">
	<?= $this->Pretty->checkVal('role[]', $role->id, in_array($role->id, $current), [
		'label-width' => '250',
		'label-text' => $role->title,
		'on-text' => __('Qualified'),
		'off-text' => __('Un-Trained'),
		'on-color' => 'success',
		'off-color' => 'danger',
		// in_array($role->id, $needed)
	]); ?>
	</div>

<?php endforeach; ?>

</div>


<?= $this->Form->button($this->Pretty->iconSave("") . "Assign Titles", ["class" => "w-100 btn-lg btn-outline-success"]); ?>
<?= $this->Form->end(); ?>
