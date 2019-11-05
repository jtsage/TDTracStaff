<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job[]|\Cake\Collection\CollectionInterface $jobs
 */
?>

<h2>Job List<?= !empty($subtitle) ? " - " . $subtitle : "" ?></h2>

<?php if (empty($subtitle)) : ?>
<p>Full list of jobs. Regular users see open, active jobs (upcoming).  Administrators see the full history of jobs. Active jobs allow changes to needed or assigned staff. Inactive, Open jobs allow changes to payroll only.  Closed jobs provide historical data only. </p>
<?php endif; ?>

<?php if ( $WhoAmI ) : ?>
<?= $this->Html->link(
	$this->Pretty->iconAdd("") . 'Add New Job',
	['action' => 'add'],
	['escape' => false, 'class' => 'btn btn-outline-success w-100 mb-3 btn-lg']
) ?>
<?php endif; ?>

<div class="mb-2 mt-4" style="border-bottom: 1px dashed #ccc;"><h4>Sort Order</h4></div>
<ul class="breadcrumb">
	<li class="breadcrumb-item"><?= $this->Paginator->sort('name') ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('category') ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('location') ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('date_start', "Start Date") ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('due_payroll_submitted', "Payroll Due") ?></li>
	<li class="breadcrumb-item"><?= $this->Paginator->sort('due_payroll_paid', "Check Date") ?></li>
</ul>

<div class="mb-2 mt-4" style="border-bottom: 1px dashed #ccc;"><h4>Job Details</h4></div>

<?php foreach ($jobs as $job): ?>
	<?php
		$locHref = "https://www.google.com/maps/search/?api=1&query=";
		$locHref .= urlencode($job->location);
	?>
	<div class="border mb-2 p-3">
		<h5><?= $job->name ?></h5>
		<div class="row">
		<div class="col-md-9">
		<ul>
			<li><em><?= h($job->category) ?></em></li>
			<li><?= h($job->detail) ?></li>
			<li><a target="_blank" class="text-info" href="<?= $locHref ?>"><?= $job->location ?></a></li>
			<li>This job starts on <?= $job->date_start->format("m/d/Y") ?>, and ends on <?= $job->date_end->format("m/d/Y") ?></li>
			<li>Payroll for this show must be submitted on or before <?= $job->due_payroll_submitted->format("m/d/Y") ?>, and will be included on paychecks cut on <?= $job->due_payroll_paid->format("m/d/Y") ?></li>
			<li>This job is <?= $job->is_open ? "OPEN" : "CLOSED" ?> and <?= $job->is_active ? "ACTIVE" : "IN-ACTIVE" ?></li>
			<li><strong>Staff Required: </strong>
			<?php
				$needed = [];
				foreach ( $job->roles as $role ) {
					$needed[] = $role->title . " <em>(" . $role->_joinData->number_needed . ")</em>";
				}
				echo join($needed, ", ");
			?>
			</li>
			<li><strong>Staff Assigned: </strong></li>
		</ul>
		</div><div class="col-md-3">
		<div class="btn-group-vertical w-100">
		<?= $this->Html->link(
			$this->Pretty->iconView($job->id) . 'View',
			['action' => 'view', $job->id],
			['escape' => false, 'class' => 'btn btn-outline-dark']
		) ?>
		<?php if ($WhoAmI) : ?>
		<?= $this->Html->link(
			$this->Pretty->iconSNeed($job->id) . 'Staff Needed',
			['action' => 'staffNeed', $job->id],
			['escape' => false, 'class' => 'btn btn-outline-info']
		) ?>
		<?= $this->Html->link(
			$this->Pretty->iconSAssign($job->id) . 'Staff Asssigned',
			['action' => 'staffAssign', $job->id],
			['escape' => false, 'class' => 'btn btn-outline-info']
		) ?>
		<?= $this->Html->link(
			$this->Pretty->iconEdit($job->id) . 'Edit',
			['action' => 'edit', $job->id],
			['escape' => false, 'class' => 'btn btn-outline-success']
		) ?>
		<?= $this->Form->postLink(
			$this->Pretty->iconDelete($job->id) . 'Remove',
			['action' => 'delete', $job->id],
			['escape' => false, 'class' => 'btn btn-outline-primary', 'confirm' => 'Are you sure you want to delete job (ALL!!)?']
		) ?>
		<?php endif; ?>
		</div></div></div>
	</div>
<?php endforeach; ?>



	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->first('<< ' . __('first')) ?>
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
			<?= $this->Paginator->last(__('last') . ' >>') ?>
		</ul>
		<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
	</div>
</div>
