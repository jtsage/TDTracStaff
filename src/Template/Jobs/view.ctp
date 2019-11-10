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

	$percent_Done = intval(($count_Assigned / $count_Needed) * 100);
?>

<h4><?= $job->category . ": " . $job->name ?></h4>
<div class="btn-group btn-group-sm-vertical w-100 mb-2">
	<?= $this->Html->link(
		$this->Pretty->iconTUp($job->id) . 'My Availability',
		['action' => 'available', $job->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-warning']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconUnpaid($job->id) . 'My Hours',
		['controller' => 'hours', 'action' => 'add-to-job', $job->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-warning']
	) ?>
</div>

<?php if ($WhoAmI) : ?>
	<div class="btn-group btn-group-sm-vertical w-100 mb-2">
	<?= $this->Html->link(
		$this->Pretty->iconPrint($job->id) . 'Print Scheduled',
		['action' => 'print', $job->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-dark']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconSNeed($job->id) . 'Set Staff Needed',
		['action' => 'staffNeed', $job->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-info']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconMail($job->id) . 'E-Mail Needs',
		['action' => 'email', $job->id],
		['escape' => false, 'class' => 'loadingClick text-left text-md-center w-100 btn btn-outline-dark']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconSAssign($job->id) . 'Assign Staff',
		['action' => 'staffAssign', $job->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-info']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconEdit($job->id) . 'Edit',
		['action' => 'edit', $job->id],
		['escape' => false, 'class' => 'text-left text-md-center w-100 btn btn-outline-success']
	) ?>
	</div>
<?php endif; ?>


<div class="row pl-3">
	<div class="col-12 mt-3 mb-1 p-0" style="border-bottom: 1px dashed #ccc;"><h5 class="p-0 m-0 mb-1">Details</h5></div>
	<div class="col-12 border-bottom">
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

	<div class="col-12 mt-4 mb-1 p-0" style="border-bottom: 1px dashed #ccc;"><h5 class="p-0 m-0 mb-1">You</h5></div>
	<div class="col-12 border-bottom">
		<dl class="m-0">
			<dt>My Status</dt>
			<dd class="m-0 ml-3">
				<span class="badge badge-pill badge-<?= ["primary", "danger", "success"][$my_Status] ?>"><?= ["Not Interested", "Interested", "Scheduled"][$my_Status] ?></span> 
				<em><?= $this->Pretty->joinAnd($my_Roles); ?></em>
			</dd>
		</dl>
	</div>

	<div class="col-12 mt-4 mb-1 p-0" style="border-bottom: 1px dashed #ccc;"><h5 class="p-0 m-0 mb-1">Staffing</h5></div>
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
			<div class="progress mb-md-2" title="<?= $count_Assigned ?> staff assigned to <?= $count_Needed ?> positions" style="height: 8px">
				<div class="progress-bar progress-bar-striped bg-info text-dark" role="progressbar" style="width: <?= $percent_Done ?>%" aria-valuenow="<?= $percent_Done ?>" aria-valuemin="0" aria-valuemax="100"><?= $percent_Done ?>%</div>
			</div>
			<div class="text-muted text-center mb-2 d-md-none"><?= $count_Assigned ?> staff assigned to <?= $count_Needed ?> positions</div>
		</div>
	<?php endif; ?>
</div>

<div class="row">
	<div class="col-12 mt-4 mb-1 p-0" style="border-bottom: 1px dashed #ccc;"><h5 class="p-0 m-0 mb-1">Location</h5></div>
	<div class="col-12 border-bottom">
		<dl class="m-0"><dt>Link</dt><dd class="m-0 ml-3"><a target="_blank" class="text-info" href="<?= $locHref ?>"><?= $job->location ?></a></dd></dl>
	</div>

	<div class="col-md-6 mx-auto col-12">
		<div class="embed-responsive embed-responsive-4by3">
			<div id="map-container" class="embed-responsive-item">
				<div id="map">
					<iframe width="600" height="500" id="map_canvas" src="https://maps.google.com/maps?q=<?=urlencode($job->location)?>&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no"></iframe>
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