<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>
<?php
	$count_Needed    = 0;
	$count_Assigned  = 0;
	$count_Available = 0;

	$names_Needed    = [];
	$names_Assigned  = [];
	$names_Available = [];

	$job_Roles = [];
	$my_Roles  = [];
	$my_Status = 0;

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

	if ( !empty($yourStat) ) {
		if ( $yourStat->is_available ) {
			$my_Status = 1;
		}
		if ( $yourStat->is_scheduled ) {
			$my_Status = 2;
		}
	}

	$IAm = $this->request->getSession()->read('Auth.User.id');
	
	foreach ( $job->roles as $role ) {
		$names_Needed[]       = $role->title . " <em>(" . $role->_joinData->number_needed . ")</em>";
		$count_Needed        += $role->_joinData->number_needed;
		$job_Roles[$role->id] = $role->title;
	}

	$theseNames  = [];
	$theseCounts = [];

	foreach ( $job->users_sch as $user ) {
		if ( $user->id == $IAm ) {
			$my_Roles[] = $job_Roles[ $user->_joinData->role_id ];
		}
		$count_Assigned += 1;
		if ( array_key_exists($user->id, $theseCounts) ) {
			$theseCounts[$user->id] += 1;
		} else {
			$theseCounts[$user->id] = 1;
			$theseNames[$user->id]  = $user->first . " " . $user->last;
		}
	}
	foreach ( $theseCounts as $key => $value ) {
		$names_Assigned[] = "<a class='text-info' href='/users/view/" . $key . "'>" . $theseNames[$key] . (($value > 1 ) ? " <em>(".$value.")</em>":"") . "</a>";
	}

	$theseNames  = [];
	$theseCounts = [];

	foreach ( $job->users_int as $user ) {
		$count_Available += 1;
		if ( array_key_exists($user->id, $theseCounts) ) {
			$theseCounts[$user->id] += 1;
		} else {
			$theseCounts[$user->id] = 1;
			$theseNames[$user->id]  = $user->first . " " . $user->last;
		}
	}
	foreach ( $theseCounts as $key => $value ) {
		$names_Available[] = "<a class='text-info' href='/users/view/" . $key . "'>" . $theseNames[$key] . (($value > 1 ) ? " <em>(".$value.")</em>":"") . "</a>";
	}

	$percent_Done = ($count_Needed == 0) ? 0 : intval(($count_Assigned / $count_Needed) * 100);

?>

<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
	<div class="text-dark mb-4"><span class="h3"><?= $job->category . ": " . $job->name ?></span>
		<?= ( $job->has_budget ) ? "<span class=\"float-right badge ml-1 badge-warning\">Budgeted</span>" : "" ?>
		<?= ( !$job->has_payroll ) ? "<span class=\"float-right badge ml-1 badge-warning\">No Payroll</span>" : "" ?>
		<span class="float-right badge ml-1 badge-<?= $actStyle[0] ?>"><?= $actStyle[1] ?></span>
		<span class="float-right badge ml-1 badge-<?= $openStyle[0] ?>"><?= $openStyle[1] ?></span>
</div>

	<?php if ($WhoAmI) : ?>
		<?= $this->HtmlExt->iconBtnLink(
			"calendar-edit", 'Edit Job',
			['action' => 'edit', $job->id],
			['class' => 'w-100 mb-2 btn btn-outline-success']
		) ?>
	<?php endif; ?>

	<div class="row">
		<div class="col-12 border-bottom border-top">
			<dl class="m-0"><dt>Description</dt><dd class="m-0 ml-3"><?= $job->detail ?></dd></dl>
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

<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
	<div class="row">
		<div class="col-12 p-0 text-dark text-center"><h5 class="p-0 m-0 mb-2">Your Information</h5></div>
		<div class="col-12 border-bottom py-0 m-0">
			<div class="btn-group btn-group-sm-vertical w-100 m-0 mb-1">
				<?= $this->HtmlExt->iconBtnLink(
					'calendar-check', 'My Availability',
					['action' => 'available', $job->id],
					['class' => 'text-left text-md-center w-100 btn btn-outline-info']
				) ?>
				<?= ($job->has_payroll) ? $this->HtmlExt->iconBtnLink(
					"account-cash", 'Add My Hours',
					['controller' => 'payrolls', 'action' => 'add', $job->id],
					['class' => 'text-left text-md-center w-100 btn btn-outline-info']
				) : "" ?>
				<?= ($job->has_payroll) ? $this->HtmlExt->iconBtnLink(
					"cash", 'View My Payroll',
					['controller' => 'payrolls', 'action' => 'myjob', $job->id],
					['class' => 'text-left text-md-center btn w-100 btn-outline-warning']
				) : "" ?>
			</div>
		</div>
		<div class="col-12 border-bottom">
			<dl class="m-0">
				<dt>My Status</dt>
				<dd class="m-0 ml-3">
					<span class="badge badge-pill badge-<?= ["primary", "danger", "success"][$my_Status] ?>"><?= ["Not Interested", "Interested", "Scheduled"][$my_Status] ?></span> 
					<em><?= $this->Pretty->joinAnd($my_Roles); ?></em>
				</dd>
			</dl>
		</div>
		<?php
			$myTot = (!is_null($userTotals) ? $userTotals->total_worked :0);
			$myUpd = (!is_null($userTotals) ? $userTotals->total_unpaid :0);
			$myPad = (!is_null($userTotals) ? $userTotals->total_paid :0);
			$myPrc = (is_null($userTotals) ? 0 : intval(($myPad / $myTot) * 100));
		?>
		<div class="col-sm-12 col-md-6 border-bottom">
			<dl class="m-0"><dt>Your Hours Submitted</dt><dd class="m-0 ml-3"><?= number_format($myTot, 2) ?></dd></dl>
		</div>
		<div class="col-sm-12 col-md-6 border-bottom">
			<dl class="m-0"><dt>Your Hours Pending Payment</dt><dd class="m-0 ml-3"><?= number_format($myUpd, 2) ?></dd></dl>
		</div>
		<div class="col-12 mt-1">
			<div class="border progress mb-md-2" title="<?= number_format($myPad,2) ?> paid hours of <?= number_format($myTot,2) ?> total">
				<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?= $myPrc ?>%" aria-valuenow="<?= $myPrc ?>" aria-valuemin="0" aria-valuemax="100"><?= $myPrc ?>% My Hours Paid</div>
			</div>
		</div>
	</div>
</div>
	

<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
	<div class="row">
		<div class="col-12 p-0 text-dark text-center"><h5 class="p-0 m-0 mb-2">Staffing Information</h5></div>
	</div><div class="row">
		<div class="<?= (!$WhoAmI)?"col-12":"col-md-9" ?> p-0">
			<div class="col-12 border-bottom">
				<dl class="m-0">
					<dt>Staffing Required</dt>
					<dd class="m-0 ml-3">
						<strong><?= $count_Needed ?></strong> -
						<?= $this->Pretty->joinAnd($names_Needed); ?>
					</dd>
				</dl>
			</div>
			<div class="col-12 border-bottom">
				<dl class="m-0">
					<dt>Staffing Assigned</dt>
					<dd class="m-0 ml-3">
						<strong><?= $count_Assigned ?></strong> -
						<?= $this->Pretty->joinAnd($names_Assigned); ?>
					</dd>
				</dl>
			</div>
			<?php if ( $WhoAmI ) : ?>
				<div class="col-12 border-bottom">
					<dl class="m-0">
						<dt>Staffing Available</dt>
						<dd class="m-0 ml-3">
							<strong><?= $count_Available ?></strong> -
							<?= $this->Pretty->joinAnd($names_Available); ?>
						</dd>
					</dl>
				</div>
				<div class="col-12 mt-1">
					<div class="border progress mb-md-2" title="<?= $count_Assigned ?> staff assigned to <?= $count_Needed ?> positions">
						<div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: <?= $percent_Done ?>%" aria-valuenow="<?= $percent_Done ?>" aria-valuemin="0" aria-valuemax="100"><?= $percent_Done ?>% Staffed</div>
					</div>
					<div class="text-muted text-center mb-2 d-md-none"><?= $count_Assigned ?> staff assigned to <?= $count_Needed ?> positions</div>
				</div>
			<?php endif; ?>
		</div>
		<?php if ($WhoAmI) : ?>
			<div class="col-md-3 border-bottom py-0 m-0">
				<div class="btn-group-vertical w-100 mb-2">
				<?= $this->HtmlExt->iconBtnLink(
					"printer", 'Print Scheduled',
					['action' => 'print', $job->id],
					['class' => 'text-left w-100 btn btn-outline-dark']
				) ?>
				<?= $this->HtmlExt->iconBtnLink(
					"account-multiple-plus", 'Set Staff Needed',
					['action' => 'staffNeed', $job->id],
					['class' => 'text-left w-100 btn btn-outline-info']
				) ?>
				<?= $this->HtmlExt->iconBtnLink(
					"email", 'E-Mail Needs',
					"#",
					[
						'data-jobid' => $job->id,
						'class' => 'emailNeedBtn text-left w-100 btn btn-outline-warning'
					]
				) ?>
				<?= $this->HtmlExt->iconBtnLink(
					"account-multiple-check", 'Assign Staff',
					['action' => 'staffAssign', $job->id],
					['class' => 'text-left w-100 btn btn-outline-info']
				) ?>
				<?= $this->HtmlExt->iconBtnLink(
					"account-supervisor", 'Force Staff',
					['action' => 'forceStaffAssign', $job->id],
					['class' => 'text-left w-100 btn btn-outline-danger']
				) ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php if ( $WhoAmI && $job->has_payroll ) : ?>
	<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
		<div class="row">
			<div class="col-12 p-0 text-dark text-center "><h5 class="p-0 m-0 mb-2">Payroll Information</h5></div>
			<div class="col-12 border-bottom pb-2"><div class="btn-group btn-group-sm-vertical w-100">
				<?= $this->HtmlExt->iconBtnLink(
					"cash", 'View All Payroll',
					['controller' => 'payrolls', 'action' => 'job', $job->id],
					['class' => 'btn w-100 text-left text-md-center btn-outline-warning']
				) ?>
				<?= $this->HtmlExt->iconBtnLink(
					"account-cash", 'Force Add Payroll',
					['controller' => 'payrolls', 'action' => 'addForce', $job->id],
					['class' => 'btn w-100 text-left text-md-center btn-outline-danger']
				) ?>
			</div></div>
			<?php
				$jobTot = (!is_null($jobTotals) ? $jobTotals->total_worked :0);
				$jobUpd = (!is_null($jobTotals) ? $jobTotals->total_unpaid :0);
				$jobPad = (!is_null($jobTotals) ? $jobTotals->total_paid :0);
				$jobPrc = (is_null($jobTotals) ? 0 : intval(($jobPad / $jobTot) * 100));
			?>
			<div class="col-sm-12 col-md-6 border-bottom">
				<dl class="m-0"><dt>Total Hours Submitted</dt><dd class="m-0 ml-3"><?= number_format($jobTot, 2) ?></dd></dl>
			</div>
			<div class="col-sm-12 col-md-6 border-bottom">
				<dl class="m-0"><dt>Total Hours Pending Payment</dt><dd class="m-0 ml-3"><?= number_format($jobUpd, 2) ?></dd></dl>
			</div>
			<div class="col-12 mt-1">
				<div class="border progress mb-md-2" title="<?= number_format($jobPad,2) ?> paid hours of <?= number_format($jobTot,2) ?> total">
					<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?= $jobPrc ?>%" aria-valuenow="<?= $jobPrc ?>" aria-valuemin="0" aria-valuemax="100"><?= $jobPrc ?>% Total Hours Paid</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ( $BudgetAmI && $job->has_budget ) : ?>
	<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
		<div class="row">
			<div class="col-12 p-0 text-dark text-center "><h5 class="p-0 m-0 mb-2">Budget Information</h5></div>
			<div class="col-12 border-bottom pb-2"><div class="btn-group btn-group-sm-vertical w-100">
				<?= $this->HtmlExt->iconBtnLink(
					"credit-card-clock", 'View Budget',
					['controller' => 'budgets', 'action' => 'view', $job->id],
					['class' => 'btn w-100 text-left text-md-center btn-outline-warning']
				) ?>
				<?= $this->HtmlExt->iconBtnLink(
					"credit-card-plus", 'Add Budget Item',
					['controller' => 'budgets', 'action' => 'add', $job->id],
					['class' => 'btn w-100 text-left text-md-center btn-outline-success']
				) ?>
			</div></div>
			<?php 
				$budAloc  = array_key_exists($job->id, $budgeTotal) ? $budgeTotal[$job->id] : 0;
				$budAllow = $job->has_budget_total;
				$budPerc  = ( $job->has_budget_total == 0 ) ? 0 : intval(($budAloc / $budAllow) * 100);
			?>
			<div class="col-sm-12 col-md-6 border-bottom">
				<dl class="m-0"><dt>Budget Allocated</dt><dd class="<?= ( $budAloc > $budAllow ) ? "text-danger" : "text-success" ?> m-0 ml-3">$<?= number_format($budAloc, 2) ?></dd></dl>
			</div>
			<div class="col-sm-12 col-md-6 border-bottom">
				<dl class="m-0"><dt>Budget Allowed</dt><dd class="m-0 ml-3">$<?= number_format($budAllow, 2) ?></dd></dl>
			</div>
			<div class="col-12 mt-1">
				<div class="border progress mb-md-2" title="$<?= number_format($budAloc,2) ?> used of $<?= number_format($budAllow,2) ?> total">
					<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= $budPerc ?>%" aria-valuenow="<?= $budPerc ?>" aria-valuemin="0" aria-valuemax="100"><?= $budPerc ?>% Budget Allocated</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
	<div class="row">
		<div class="col-12 border-bottom p-0 text-center text-dark"><h5 class="p-0 m-0 mb-2">Job Notes</h5></div>
		<div class="p-4" style="line-height: initial;"><?= nl2br($job->notes) ?></div>
	</div>
</div>

<div class="card rounded border shadow-sm mb-2 px-3 pt-3">
	<div class="row">
		<div class="col-12 border-bottom p-0 text-center text-dark"><h5 class="p-0 m-0 mb-2">Location Information &amp; Map</h5></div>
		<div class="col-12 border-bottom">
			<dl class="m-0"><dt>Link</dt><dd class="m-0 ml-3"><a target="_blank" class="text-info" href="<?= $locHref ?>"><?= $job->location ?></a></dd></dl>
		</div>

		<div class="col-md-6 mx-auto p-4 col-12">
			<div class="embed-responsive embed-responsive-4by3">
				<div id="map-container" class="embed-responsive-item">
					<div id="map">
						<iframe width="600" height="500" id="map_canvas" src="https://maps.google.com/maps?q=<?=urlencode($job->location)?>&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no"></iframe>
					</div>
				</div> 
			</div>
		</div>
	</div>
</div>

<?= $this->Pretty->helpMeStart("Job Details"); ?>

<p>This display shows a the detail of a particular job.</p>

<h4>Is Open / Is Active status</h4>
<p>Active jobs are those jobs that are accepting staff availability information, staff
assignment information, and payroll information. Active jobs have not yet been paid out 
in most cases. Jobs should typically be marked inactive when their paychecks are disbursed.</p>

<p>Open jobs are those jobs that still appear in a regular users list - for instance, and
in-active but still open job provides a way for an employee to track what they are due on
a future paycheck.  Jobs should be typically be marked as closed a pay period after their
paychecks are disbursed</p>

<h4>Administrator Information</h4>
<p>The progress bar for each job indicates how many of the required positions have been
filled for that job.</p>

<p>The "Staff Needed" section indicates how many positions that job has that
need filled.  When a single employee can fill multiple roles, this number may be higher
than the true number of employees required.</p>

<p>The "Staff Assigned" section indicates how many employees have been scheduled for the
job. Note that a single employee may fill multiple roles on the same job.</p>

<p>The "Staff Available" section indicates how many employees have been indicated their
availability for the job. By default, the system assumes an employee is unavailable, only
those who have explicitly consented are shown here.</p>

<p>The "E-Mail Needs" button on the will have the system notify
employees with the appropriate training profile that there is a new job that needs staffing (or
remind them of an existing job that still needs more staffing). Note that this may take several
seconds to load, and will "lock" the page while working.</p>

<?= $this->Pretty->helpMeEnd(); ?>