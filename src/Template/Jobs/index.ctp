<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job[]|\Cake\Collection\CollectionInterface $jobs
 */
?>

<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Job List<?= !empty($subtitle) ? " - " . $subtitle : "" ?></h3>

	<?php if (empty($subtitle)) : ?>
	<p>Full list of jobs. Regular users see open, active jobs (upcoming).  Administrators see the full history of jobs. Active jobs allow changes to needed or assigned staff. Inactive, Open jobs allow changes to payroll only.  Closed jobs provide historical data only. </p>
	<?php elseif ( !empty($subtext)) : ?>
	<p><?= $subtext ?></p>
	<?php endif; ?>

	<?php if ( $WhoAmI && empty($subtitle) ) : ?>
	<?= $this->Html->link(
		$this->Pretty->iconAdd("") . 'Add New Job',
		['action' => 'add'],
		['escape' => false, 'class' => 'btn btn-outline-success w-100 mb-3 btn-lg']
	) ?>
	<?php endif; ?>

	<div class="btn-group btn-group-sm-vertical w-100 mb-3">
	<?= $this->Html->link(
		$this->Pretty->iconView("") . 'View All Jobs ',
		['action' => 'index'],
		['escape' => false, 'class' => 'w-100 btn btn-outline-dark']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconView("") . 'View Qualifying Jobs ',
		['action'=> 'myjobs'],
		['escape' => false, 'class' => 'w-100 btn btn-outline-dark']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconView("") . 'View Scheduled Jobs',
		['action' => 'mysched'],
		['escape' => false, 'class' => 'w-100 btn btn-outline-dark']
	) ?>
	</div>
</div>

<ul class="bg-white border shadow-sm breadcrumb">
	<li class="breadcrumb-item text-dark font-weight-bold">Sort Order</li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('name') ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('category') ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('location') ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('date_start', "Start Date") ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('due_payroll_submitted', "Payroll Due") ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('due_payroll_paid', "Check Date") ?></li>
</ul>



<?php foreach ($jobs as $job): ?>
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

		$total_Needed    = 0;
		$total_Assigned  = count($job->users_sch);
		$total_Available = count($job->users_int);

		foreach ( $job->roles as $role ) {
			$total_Needed += $role->_joinData->number_needed;
		}

		$percent_Done = ($total_Needed == 0) ? 0 : intval(($total_Assigned / $total_Needed) * 100);

		if ( $WhoAmI ) {
			if ( array_key_exists($job->id, $jobTotals) ) {
				$pay_Total   = $jobTotals[$job->id]["total_worked"];
				$pay_Paid    = $jobTotals[$job->id]["total_paid"];
				$pay_Unpaid  = $jobTotals[$job->id]["total_unpaid"];
				$pay_Percent = intval(($pay_Paid / $pay_Total) * 100);
			} else {
				$pay_Total   = 0;
				$pay_Paid    = 0;
				$pay_Unpaid  = 0;
				$pay_Percent = 0;
			}
		} else {
			if ( array_key_exists($job->id, $myTotals) ) {
				$pay_Total   = $myTotals[$job->id]["total_worked"];
				$pay_Paid    = $myTotals[$job->id]["total_paid"];
				$pay_Unpaid  = $myTotals[$job->id]["total_unpaid"];
				$pay_Percent = intval(($pay_Paid / $pay_Total) * 100);
			} else {
				$pay_Total   = 0;
				$pay_Paid    = 0;
				$pay_Unpaid  = 0;
				$pay_Percent = 0;
			}
		}
	?>
	<div class="card p-3 rounded border shadow-sm mb-2">
		<div class="row">
			<div class="col-md-9 m-0">
				<h5 class="text-dark"><?= $job->category . ": " . $job->name ?>
					<?php if ( $WhoAmI ) : ?>
						<a href="#" data-change="active" data-name="<?= $job->name ?>" data-job="<?= $job->id ?>" class="act-<?= $job->id ?> clickOpenAct float-right badge ml-1 badge-<?= $actStyle[0] ?>"><?= $actStyle[1] ?></a>
						<a href="#" data-change="open" data-name="<?= $job->name ?>" data-job="<?= $job->id ?>" class="open-<?= $job->id ?> clickOpenAct float-right badge ml-1 badge-<?= $openStyle[0] ?>"><?= $openStyle[1] ?></a>
					<?php else : ?>
						<span class="float-right badge ml-1 badge-<?= $actStyle[0] ?>"><?= $actStyle[1] ?></span>
						<span class="float-right badge ml-1 badge-<?= $openStyle[0] ?>"><?= $openStyle[1] ?></span>
					<?php endif; ?>
				</h5>

				<?php if ( $WhoAmI ) : ?>
					<div class="border progress mb-md-1" title="<?= $total_Assigned ?> staff assigned to <?= $total_Needed ?> positions">
						<div class="progress-bar progress-bar-striped bg-purp " role="progressbar" style="width: <?= $percent_Done ?>%" aria-valuenow="<?= $percent_Done ?>" aria-valuemin="0" aria-valuemax="100"><?= $percent_Done ?>% Staffed</div>
					</div>
					<div class="text-muted text-center d-md-none mb-2"><?= $total_Assigned ?> staff assigned to <?= $total_Needed ?> positions</div>
				<?php endif; ?>

				<div class="border progress mb-md-2" title="<?= $pay_Paid ?> hours paid out of <?= $pay_Total ?> total">
					<div class="progress-bar progress-bar-striped bg-info " role="progressbar" style="width: <?= $pay_Percent ?>%" aria-valuenow="<?= $pay_Percent ?>" aria-valuemin="0" aria-valuemax="100"><?= $pay_Percent ?>% <?= ($WhoAmI?"Total":"") ?> Paid</div>
				</div>
				<div class="text-muted text-center d-md-none mb-2"><?= $pay_Paid ?> hours paid out of <?= $pay_Total ?> total</div>

				<div class="row pl-3">
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
					<div class="col-sm-12 col-md-6 border-bottom">
						<dl class="m-0"><dt><?= ($WhoAmI)?"All":"Your" ?> Hours Total</dt><dd class="m-0 ml-3"><?= number_format($pay_Total, 2) ?></dd></dl>
					</div>
					<div class="col-sm-12 col-md-6 border-bottom">
						<dl class="m-0"><dt><?= ($WhoAmI)?"All":"Your" ?> Hours Unpaid</dt><dd class="m-0 ml-3"><?= number_format($pay_Unpaid, 2) ?></dd></dl>
					</div>
				</div>
			</div><div class="col-md-3">
				<div class="btn-group-vertical w-100">
				<?= $this->Html->link(
					$this->Pretty->iconView($job->id) . 'View Detail',
					['action' => 'view', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-dark']
				) ?>
				<?= $this->Html->link(
					$this->Pretty->iconTUp($job->id) . 'My Availability',
					['action' => 'available', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-warning']
				) ?>
				<?= $this->Html->link(
					$this->Pretty->iconUnpaid($job->id) . 'Add My Hours',
					['controller' => 'payrolls', 'action' => 'add', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-warning']
				) ?>
				</div><div class="btn-group-vertical mt-1 w-100">
				<?= $this->Html->link(
					$this->Pretty->iconUnpaid($job->id) . 'View '. ($WhoAmI?"":"My ") .'Payroll',
					['controller' => 'payrolls', 'action' => 'job', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-danger']
				) ?>
				</div>
				<?php if ($WhoAmI) : ?>
				<div class="btn-group-vertical mt-1 w-100">
				<?= $this->Html->link(
					$this->Pretty->iconPrint($job->id) . 'Print Scheduled',
					['action' => 'print', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-dark']
				) ?>
				<?= $this->Html->link(
					$this->Pretty->iconSNeed($job->id) . 'Staff Needed (' . $total_Needed . ")",
					['action' => 'staffNeed', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-info']
				) ?>
				<?= $this->Html->link(
					$this->Pretty->iconSAssign($job->id) . 'Staff Assigned (' . $total_Assigned . "/" . $total_Available .')',
					['action' => 'staffAssign', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-info']
				) ?>
				</div><div class="btn-group-vertical mt-1 w-100">
				<?= $this->Html->link(
					$this->Pretty->iconEdit($job->id) . 'Edit',
					['action' => 'edit', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-success']
				) ?>
				<?= $this->Form->postLink(
					$this->Pretty->iconDelete($job->id) . 'Remove',
					['action' => 'delete', $job->id],
					['escape' => false, 'class' => 'btn btn-sm text-left btn-outline-primary', 'confirm' => 'Are you sure you want to delete job (ALL!!)?']
				) ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>


<div class="card rounded border p-2 shadow-sm">
	<div class="paginator">
		<ul class="pagination justify-content-center mb-2">
			<?= $this->Paginator->first('<< ' . __('first')) ?>
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
			<?= $this->Paginator->last(__('last') . ' >>') ?>
		</ul>
		<p class="text-center text-muted small m-0"><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
	</div>
</div>


<?= $this->Pretty->helpMeStart("Job List"); ?>

<p>This display shows a list of jobs in the system.  Qualified jobs are jobs that your
training profile indicates you are eligible to perform.  Scheduled jobs are those jobs 
that you have been scheduled to perform.</p>

<p>Sort options are available to sort by name, category, location, start date of the 
job, payroll due date, or paycheck disbursement date.</p>

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

<p>The button label for "Staff Needed" indicates how many positions that job has that
need filled.  When a single employee can fill multiple roles, this number may be higher
than the true number of employees required.</p>

<p>The button label for "Staff Assigned" indicates how many employees have been scheduled
followed by how many employees have indicated they are available for the required roles.
Employees that are willing to provide multiple types of work are counted for each role they
have indicated interest in.</p>

<?= $this->Pretty->helpMeEnd(); ?>

