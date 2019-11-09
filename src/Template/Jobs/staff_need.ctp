<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>
<h3>Staff Requirements - <?= h($job->name) ?></h4>
<p><em><?= h($job->category) ?> :</em><?= $job->detail ?></p>
<p>Enter the number of each type of employee that you require for this job.</p>

<?= $this->Form->create(null, ['align' => [
	'sm' => [
		'left'   => 6,
		'middle' => 6,
		'right'  => 12
	],
	'md' => [
		'left'   => 4,
		'middle' => 6,
		'right'  => 2
	]
]]) ?>

<fieldset>
	<?php
		foreach ( $roles as $role ) {
			$value = 0;
			foreach ( $needed as $need ) {
				if ( $need->role_id == $role->id ) { $value = $need->number_needed; }
			}
			echo $this->Form->control($role->id, ["value" => $value, "label" => $role->title, "help" => $role->detail, "autocomplete" => "new-user-address"]);
		}
	?>
</fieldset>
<?= $this->Form->button($this->Pretty->iconSave("") . __('Set Staff Requirements'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
<?= $this->Form->end() ?>
