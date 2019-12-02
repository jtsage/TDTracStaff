<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job[]|\Cake\Collection\CollectionInterface $jobs
 */
?>

<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Full Job List</h3>

	<?= $this->HtmlExt->iconBtnLink(
		"calendar-plus", 'Add New Job',
		['action' => 'add'],
		['class' => 'btn btn-outline-success w-100 mb-3 btn-lg']
	) ?>
</div>

<div class="card rounded border shadow-sm mb-2">
<table class="table table-striped table-bordered mb-0">
<tr><th>Name</th><th>Status</th><th>Date</th><th class="text-center">Actions</th></tr>

<?php foreach ($jobs as $job): ?>
	<tr>
		<?php
			$actStyle = [
				( $job->is_active ) ? "success" : "danger",
				( $job->is_active ) ? "Active" : "In-Active"
			];
			$openStyle = [
				( $job->is_open ) ? "success" : "danger",
				( $job->is_open ) ? "Open" : "Closed"
			];
		?>
		<td class="align-middle">
			<?= $job->category . ": " . $job->name ?>
			<?= !is_null($job->parent_id) ? "<span class=\"float-right mt-1 badge badge-info\">is a Sub-Job</span>" : "" ?>
			<?= !empty($job->children) ? "<span class=\"float-right mt-1 badge badge-info\">has Sub-Jobs</span>" : "" ?>
		</td>
		<td class="align-middle">
			<span style="width:48%" class="badge badge-<?= $openStyle[0] ?>"><?= $openStyle[1] ?></span>
			<span style="width:48%" class="badge badge-<?= $actStyle[0] ?>"><?= $actStyle[1] ?></span>
		</td>
		<td class="text-right align-middle">
			<?= $job->date_start->format("Y-m-d") ?>
		</td>
		<td class="text-center">
			<?= $this->HtmlExt->iconBtnLink(
				"calendar-text", 'View Detail',
				['action' => 'view', $job->id],
				['class' => 'btn btn-md w-100 text-center btn-outline-primary']
			) ?>
		</td>
	</tr>
<?php endforeach; ?>
</table></div>



<?= $this->Pretty->helpMeStart("Job List"); ?>

<p>This display shows a short list of jobs in the system.</p>

<h4>Is Open / Is Active status</h4>
<p>Active jobs are those jobs that are accepting staff availability information, staff
assignment information, and payroll information. Active jobs have not yet been paid out 
in most cases. Jobs should typically be marked inactive when their paychecks are disbursed.</p>

<p>Open jobs are those jobs that still appear in a regular users list - for instance, and
in-active but still open job provides a way for an employee to track what they are due on
a future paycheck.  Jobs should be typically be marked as closed a pay period after their
paychecks are disbursed</p>

<?= $this->Pretty->helpMeEnd(); ?>

