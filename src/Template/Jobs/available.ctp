<h4><?= $job->name ?></h4>
<?php
	$locHref = "https://www.google.com/maps/search/?api=1&query=";
	$locHref .= urlencode($job->location);

	$needed = [];
	foreach ( $job->roles as $role ) {
		$needed[] = $role->title . " <em>(" . $role->_joinData->number_needed . ")</em>";
	}
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
	<tr><th>Staff Needed</th><td><?= join($needed, ", ") ?></td></tr>
</table>

<div style="border-bottom: 1px dashed #ccc;" class="mt-3 mb-2"><h5>Your Availability</h5></div>
<table class="table table-bordered">
	<tr><th>Job Title</th><th>Current Status</th><th class="text-center">Actions</th></tr>

<?php foreach ( $job->roles as $roleNeeded ) : ?>
	<?php if ( in_array($roleNeeded->id, $trained) ) : ?>
		<tr>
			<td class="align-middle"><?= $roleNeeded->title ?></td>
			<td class="align-middle"><?php
				$newEntry = true;
				$avail = false;
				$sched = false;
				foreach ( $assigned as $ass ) {
					if ( $ass->role_id == $roleNeeded->id ) {
						$newEntry = false;
						$avail = $ass->is_available;
						$sched = $ass->is_scheduled;
					}
				}
				if ( $newEntry ) { 
					echo "Assumed Unavailable, please select!";
				} else {
					if ( !$avail ) { echo "Unavailable"; } else { echo "Interested"; }
					if ( !$sched ) { echo ", not scheduled"; } else { echo ", <strong><em>and Scheduled</strong></em>!"; }
				}
			?></td>
			<td><div class="btn-group w-100">
				<?php if ( $newEntry ) : ?>
					<?= $this->Html->link(
						$this->Pretty->iconTUp($job->id) . 'Interested',
						['action' => 'new-avail', $job->id, $roleNeeded->id, 1],
						['escape' => false, 'class' => 'btn w-50 btn-outline-success']
					) ?>
					<?= $this->Html->link(
						$this->Pretty->iconTDown($job->id) . 'Un-Available',
						['action' => 'new-avail', $job->id, $roleNeeded->id, 0],
						['escape' => false, 'class' => 'btn w-50 btn-outline-primary']
					) ?>
				<?php else : ?>
					<?= $this->Html->link(
						$this->Pretty->iconTUp($job->id) . 'Interested',
						['action' => 'change-avail', $job->id, $roleNeeded->id, 1],
						['escape' => false, 'class' => 'btn w-50 btn-outline-'.($sched?'dark disabled':"success")]
					) ?>
					<?= $this->Html->link(
						$this->Pretty->iconTDown($job->id) . 'Un-Available',
						['action' => 'change-avail', $job->id, $roleNeeded->id, 0],
						['escape' => false, 'class' => 'btn w-50 btn-outline-'.($sched?'dark disabled':"primary")]
					) ?>
				<?php endif; ?>
			</div></td>
		</tr>
	<?php endif; ?>

<?php endforeach; ?>
</table>