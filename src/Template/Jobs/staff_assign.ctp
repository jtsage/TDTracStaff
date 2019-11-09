<h4><?= $job->name ?></h4>
<?php
	$locHref = "https://www.google.com/maps/search/?api=1&query=";
	$locHref .= urlencode($job->location);
?>
<table class="table">
	<tr><th>Category</th><td><?= $job->category ?></td></tr>
	<tr><th>Description</th><td><?= $job->detail ?></td></tr>
	<tr><th>Start Date</th><td><?= $job->date_start->format("m/d/Y") ?></td></tr>
	<tr><th>End Date</th><td><?= $job->date_end->format("m/d/Y") ?></td></tr>
	<tr><th>Time(s)</th><td><?= $job->time_string ?></td></tr>
	<tr><th>Payroll Due Date</th><td><?= $job->due_payroll_submitted->format("m/d/Y") ?></td></tr>
	<tr><th>Paycheck Date</th><td><?= $job->due_payroll_paid->format("m/d/Y") ?></td></tr>
	<tr><th>Location</th><td><a target="_blank" class="text-info" href="<?= $locHref ?>"><?= $job->location ?></a></td></tr>
</table>

<h4 class="mt-5 mb-4">Interested Staff</h4>
<?php foreach ( $job->roles as $role ) : ?>
	<div class="mt-3 mb-2" style="border-bottom: 1px dashed #ccc">
		<h5><?= $role->title ?> <em>(Needed: <?= $role->_joinData->number_needed ?>)</em></h5>
	</div>
	<table class="table table-bordered mb-5">
		<tr><th class="w-25">User</th><th class="w-25">Current Status</th><th class="text-center">Actions</th></tr>

		<?php foreach ( $interest as $person ): ?>
			<?php if ( $person->role_id == $role->id ) : ?>
				<tr>
					<td class="align-middle"><a href="/users/view/<?= $person->user->id ?>"><?= $person->user->first ?> <?= $person->user->last ?></td>
					<td class="align-middle">Interested, <?= $person->is_scheduled ? "<strong>and Scheduled!</strong>" : "not scheduled" ?></td>
					<td><div class="btn-group w-100">
						<?= $this->Html->link(
							$this->Pretty->iconTUp($person->id) . 'Schedule',
							['action' => 'sched-set', $person->id, 1],
							['escape' => false, 'class' => 'btn w-50 btn-outline-success' . ($person->is_scheduled?" active":"")]
						) ?>
						<?= $this->Html->link(
							$this->Pretty->iconTDown($person->id) . 'Do NOT Schedule',
							['action' => 'sched-set', $person->id, 0],
							['escape' => false, 'class' => 'btn w-50 btn-outline-primary' . ($person->is_scheduled?"":" active")]
						) ?>
						<?= $this->Html->link(
							$this->Pretty->iconMail($person->id) . 'Notify of decision',
							['action' => 'notify', $person->id],
							['escape' => false, 'class' => 'btn w-50 btn-outline-danger loadingClick']
						) ?>
					</div></td>
				</tr> 
			<?php endif; ?>
		<?php endforeach; ?>
	</table>

<?php endforeach; ?>