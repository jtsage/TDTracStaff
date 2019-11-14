<?php
	$locHref = "https://www.google.com/maps/search/?api=1&query=";
	$locHref .= urlencode($job->location);

	$actStyle = [
		( $job->is_active ) ? "success" : "primary",
		( $job->is_active ) ? "Active" : "In-Active"
	];
	$openStyle = [
		( $job->is_open ) ? "success" : "primary",
		( $job->is_open ) ? "Open" : "Closed"
	];

	$count_Needed    = 0;
	$names_Needed    = [];
	
	foreach ( $job->roles as $role ) {
		$names_Needed[]       = $role->title . " <em>(" . $role->_joinData->number_needed . ")</em>";
		$count_Needed        += $role->_joinData->number_needed;
	}
?>
<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
	<h3 class="text-dark mb-4"><?= $job->category . ": " . $job->name ?>
		<span class="float-right ml-1 badge badge-<?= $actStyle[0] ?>"><?= $actStyle[1] ?></span>
		<span class="float-right ml-1 badge badge-<?= $openStyle[0] ?>"><?= $openStyle[1] ?></span>
	</h3>

	<div class="row">
		<div class="col-12 border-bottom">
			<dl class="m-0"><dt>Description</dt><dd class="m-0 ml-3"><?= $job->detail ?></dd></dl>
		</div>
		<div class="col-12 border-bottom">
			<dl class="m-0"><dt>Location</dt><dd class="m-0 ml-3"><a target="_blank" class="text-info" href="<?= $locHref ?>"><?= $job->location ?></a></dd></dl>
		</div>
		<div class="col-sm-12 col-md-6 border-bottom">
			<dl class="m-0"><dt>Start Date</dt><dd class="m-0 ml-3"><?= $job->date_start->format("l, F j, Y") ?></dd></dl>
		</div>
		<div class="col-sm-12 col-md-6 border-bottom">
			<dl class="m-0"><dt>End Date</dt><dd class="m-0 ml-3"><?= $job->date_end->format("l, F j, Y") ?></dd></dl>
		</div>
		<div class="col-12 border-bottom">
			<dl class="m-0"><dt>Time(s)</dt><dd class="m-0 ml-3"><?= $job->time_string ?></dd></dl>
		</div>
		<div class="col-sm-12 col-md-6 border-bottom">
			<dl class="m-0"><dt>Payroll Due Date</dt><dd class="m-0 ml-3"><?= $job->due_payroll_submitted->format("l, F j, Y") ?></dd></dl>
		</div>
		<div class="col-sm-12 col-md-6 border-bottom">
			<dl class="m-0"><dt>Paycheck Date</dt><dd class="m-0 ml-3"><?= $job->due_payroll_paid->format("l, F j, Y") ?></dd></dl>
		</div>
		<div class="col-12 border-bottom">
			<dl class="m-0">
				<dt>Staffing Required</dt>
				<dd class="m-0 ml-3">
					<strong><?= $count_Needed ?></strong> -
					<?= $this->Pretty->joinAnd($names_Needed); ?>
				</dd>
			</dl>
		</div>
	</div>
</div>

<div class="card rounded border shadow-sm mb-2">
<table class="table table-bordered mb-0">
	<tr><td colspan="3" class="text-center h5">Your Availability</h5></td></tr>
	<tr><th>Job Title</th><th>Current Status</th><th class="text-center">Actions</th></tr>

<?php foreach ( $job->roles as $roleNeeded ) : ?>
	<?php if ( in_array($roleNeeded->id, $trained) ) : ?>
		<tr>
			<td class="w-25 align-middle"><?= $roleNeeded->title ?></td>
			<td class="w-25 align-middle"><?php
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
			<td><div class="btn-group btn-group-sm-vertical w-100">
				<?php if ( $newEntry ) : ?>
					<?= $this->HtmlExt->iconBtnLink(
						"thumb-up", '<span class="d-none d-md-inline">Interested</span><span class="d-md-none">Yes</span>',
						['action' => 'new-avail', $job->id, $roleNeeded->id, 1],
						['class' => 'btn w-100 text-left text-md-center btn-outline-success']
					) ?>
					<?= $this->HtmlExt->iconBtnLink(
						"thumb-down", '<span class="d-none d-md-inline">Un-Available</span><span class="d-md-none">No</span>',
						['action' => 'new-avail', $job->id, $roleNeeded->id, 0],
						['class' => 'btn w-100 text-left text-md-center btn-outline-danger']
					) ?>
				<?php else : ?>
					<?= $this->HtmlExt->iconBtnLink(
						"thumb-up", '<span class="d-none d-md-inline">Interested</span><span class="d-md-none">Yes</span>',
						['action' => 'change-avail', $job->id, $roleNeeded->id, 1],
						['class' => 'btn w-100 text-left text-md-center btn-outline-'.($sched?'dark disabled':"success")]
					) ?>
					<?= $this->HtmlExt->iconBtnLink(
						"thumb-down", '<span class="d-none d-md-inline">Un-Available</span><span class="d-md-none">No</span>',
						['action' => 'change-avail', $job->id, $roleNeeded->id, 0],
						['class' => 'btn w-100 text-left text-md-center btn-outline-'.($sched?'dark disabled':"danger")]
					) ?>
				<?php endif; ?>
			</div></td>
		</tr>
	<?php endif; ?>

<?php endforeach; ?>
</table>
</div>


<?= $this->Pretty->helpMeStart("Your Availability"); ?>

<p>This display allows you to indicate your availability for the job detailed.</p>

<p>Use the <?= $this->HtmlExt->icon("thump-up") ?> "thumbs up" or <?= $this->HtmlExt->icon("thumb-down") ?> 
"thumbs down" buttons to indicate your availability and willingness to fullfill the listed
role.</p>

<p><strong>Note:</strong> please indicate for all roles you are willing / able to do - only those roles
you specifically indicate will be shown to management for job scheduling.</p>

<?= $this->Pretty->helpMeEnd(); ?>