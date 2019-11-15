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
?>
<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
	<h3 class="text-dark mb-4"><?= $job->category . ": " . $job->name ?>
		<span class="float-right badge ml-1 badge-<?= $actStyle[0] ?>"><?= $actStyle[1] ?></span>
		<span class="float-right badge ml-1 badge-<?= $openStyle[0] ?>"><?= $openStyle[1] ?></span>
	</h3>
	<p class="text-dark text-italic"><strong class="text-danger">WARNING:</strong> This display allows you to schedule a show while ignoring a users set availabilty.  If they have not yet responded, IT WILL SET THEM TO AVAILABLE!</p>

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
	</div>
</div>
<?php $int_words = ["Set Unavailable", "Set Available", "Unknown"] ?>

<?php foreach ( $job->roles as $role ) : ?>
	<div class="card rounded border shadow-sm mb-2">
	<table class="table table-bordered mb-0">
		<tr><td colspan=3 class="text-center h5">
			<?= $role->title ?> <small><em>(Required: <?= $role->_joinData->number_needed ?>)</em></small>
		</td></tr>
		<tr><th class="w-25">User</th><th class="w-25">Current Status</th><th class="text-center">Actions</th></tr>

		<?php foreach ( $userRoles as $person ): ?>
			<?php if ( $person->role_id == $role->id ) : ?>
				<?php
					$current_int = 2;
					$current_sch = 0;
					$record_id = null;
					foreach ( $interest as $checkMe ) {
						if ( $checkMe->role_id == $role->id && $checkMe->user_id == $person->user->id ) {
							$current_int = $checkMe->is_available;
							$current_sch = $checkMe->is_scheduled;
							$record_id = $checkMe->id;
						}
					}
				?>

				<tr>
					<td class="align-middle"><a href="/users/view/<?= $person->user->id ?>"><?= $person->user->first ?> <?= $person->user->last ?></td>
					<td class="align-middle"><?= $int_words[$current_int] ?>, <?= $current_sch ? "<strong>and Scheduled!</strong>" : "not scheduled" ?></td>
					<td><div class="btn-group btn-group-sm-vertical w-100">
						<?php if ( $current_int < 2 ) : ?>
							<?= $this->HtmlExt->iconBtnLink(
								"thumb-up", 'Schedule',
								['action' => 'sched-set', $record_id, 1, 1],
								['class' => 'btn w-100 text-left text-md-center btn-outline-success' . ($current_sch?" active":"")]
							) ?>
							<?= $this->HtmlExt->iconBtnLink(
								"thumb-down", 'Do NOT<span class="d-none d-md-inline"> Schedule</span>',
								['action' => 'sched-set', $record_id, 0, 1],
								['class' => 'btn w-100 text-left text-md-center btn-outline-primary' . ($current_sch?"":" active")]
							) ?>
						<?php else : ?>
							<?= $this->HtmlExt->iconBtnLink(
								"thumb-up", 'Schedule',
								['action' => 'force-sched-set', $job->id, $role->id, $person->user->id, 1],
								['class' => 'btn w-100 text-left text-md-center btn-outline-success' . ($current_sch?" active":"")]
							) ?>
							<?= $this->HtmlExt->iconBtnLink(
								"thumb-down", 'Do NOT<span class="d-none d-md-inline"> Schedule</span>',
								['action' => 'force-sched-set', $job->id, $role->id, $person->user->id, 0],
								['class' => 'btn w-100 text-left text-md-center btn-outline-primary' . ($current_sch?"":" active")]
							) ?>
						<?php endif; ?>
						<?= $this->HtmlExt->iconBtnLink(
							"email", 'Notify<span class="d-none d-md-inline"> of decision</span>',
							['action' => 'notify', $person->id],
							['class' => 'btn w-100 text-left text-md-center btn-outline-danger loadingClick']
						) ?>
					</div></td>
				</tr> 
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
	</div>

<?php endforeach; ?>


<?= $this->Pretty->helpMeStart("Job Assigned Staff"); ?>

<p>This display allows assignment of employees to individual job roles.  Note that only
those employees who have specifically indicated their availability appear here. </p>

<p>Use the <?= $this->HtmlExt->icon("thump-up") ?> "thumbs up" or <?= $this->HtmlExt->icon("thumb-down") ?> "thumbs down" buttons to schedule employees. Note that the
"Notify" button sends a somewhat generic e-mail to the individual employee letting
them know that a decision has been made about their staffing for this job.  There
is no need to notify them multiple times, as they are instructed to follow a link
to the job details to find out what task they will be performing for the job.</p>

<p>The system will not prevent or discourage you from assigning the same employee
to multiple roles, over-staffing a job, or under-staffing a job.</p>

<?= $this->Pretty->helpMeEnd(); ?>