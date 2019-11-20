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

	$allList = [];
?>
<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
	<h3 class="text-dark mb-4"><?= $job->category . ": " . $job->name ?>
		<span class="float-right badge ml-1 badge-<?= $actStyle[0] ?>"><?= $actStyle[1] ?></span>
		<span class="float-right badge ml-1 badge-<?= $openStyle[0] ?>"><?= $openStyle[1] ?></span>
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
	</div>
</div>

<?php foreach ( $job->roles as $role ) : ?>
	<div class="card rounded border shadow-sm mb-2">
	<table class="table table-bordered mb-0">
		<tr><td colspan=3 class="text-center h5">
			<?= $role->title ?> <small><em>(Required: <?= $role->_joinData->number_needed ?>)</em></small>
		</td></tr>
		<tr><th class="w-25">User</th><th class="w-25">Current Status</th><th class="text-center">Actions</th></tr>

		<?php foreach ( $interest as $person ): ?>
			<?php $allList[$person->user->id] = true ?>
			<?php if ( $person->role_id == $role->id ) : ?>
				<tr>
					<td class="align-middle"><a href="/users/view/<?= $person->user->id ?>"><?= $person->user->first ?> <?= $person->user->last ?></td>
					<td class="align-middle">Interested, <?= $person->is_scheduled ? "<strong>and Scheduled!</strong>" : "not scheduled" ?></td>
					<td><div class="btn-group btn-group-sm-vertical w-100">
						<?= $this->HtmlExt->iconBtnLink(
							"thumb-up", 'Schedule',
							['action' => 'sched-set', $person->id, 1],
							['class' => 'btn w-100 text-left text-md-center btn-outline-success' . ($person->is_scheduled?" active":"")]
						) ?>
						<?= $this->HtmlExt->iconBtnLink(
							"thumb-down", 'Do NOT<span class="d-none d-md-inline"> Schedule</span>',
							['action' => 'sched-set', $person->id, 0],
							['class' => 'btn w-100 text-left text-md-center btn-outline-primary' . ($person->is_scheduled?"":" active")]
						) ?>
						<?= $this->HtmlExt->iconBtnLink(
							"email", 'Notify<span class="d-none d-md-inline"> of decision</span>',
							"#",
							[
								'data-recID' => $person->id,
								'data-username' => $person->user->first . " " . $person->user->last,
								'class' => 'btn w-100 text-left text-md-center btn-outline-danger emailNotifyBtn'
							]
						) ?>
					</div></td>
				</tr> 
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
	</div>

<?php endforeach; ?>

<?php if ( $CONFIG["queue-email"] ) : ?>
<div class="card rounded border shadow-sm mb-2">
	<?php
		echo $this->Form->create(null, ["action" => "notify-all/". $job->id]);
		
		foreach ( $allList as $userid => $crap ) {
			echo $this->Form->hidden("users[]", ["value" => $userid]);
		}
		echo $this->Form->button($this->HtmlExt->icon("email") . __('Notify All Employees'), ["class" => "loadingClick w-100 btn-lg m-2 btn-outline-warning"]);
		echo $this->Form->end();
	?>
</div>
<?php endif; ?>

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