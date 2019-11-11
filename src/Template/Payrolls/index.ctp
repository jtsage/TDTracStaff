<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payroll[]|\Cake\Collection\CollectionInterface $payrolls
 */
?>


<h3><?= __('Hours Submitted') ?></h3>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<?php if ( $multiUser ) : ?>
				<th scope="col">User</th>
			<?php endif; ?>
			<th scope="col">Job</th>

			<th scope="col">Date</th>

			<?php if ( $CONFIG['require-hours'] ) : ?>
				<th class="d-none d-md-table-cell" scope="col">Start Time</th>
				<th class="d-none d-md-table-cell" scope="col">End Time</th>
			<?php endif; ?>

			<th scope="col">Hours</th>
			<th class="d-none d-md-table-cell" scope="col">Paid?</th>
			<th scope="col" class="text-center"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $currentUserID = "" ?>
		<?php foreach ($payrolls as $payroll): ?>
		<tr>
			<?php if ( $multiUser ) : ?>
				<td class="align-middle">
				<span class="d-none d-md-inline"><?= $payroll->user->first ?></span>
				<?= $payroll->user->last ?>
				</td>
			<?php endif; ?>
			<td class="align-middle"><?= $payroll->job->name ?></td>

			<td class="align-middle text-right">
				<span class="d-none d-md-inline"><?= $payroll->date_worked->format("Y-m-d") ?></span>
				<span class="d-md-none"><?= $payroll->date_worked->format("m/d") ?></span>
			</td>

			<?php if ( $CONFIG['require-hours'] ) : ?>
				<td class="d-none d-md-table-cell align-middle text-right"><?= $payroll->time_start->format("H:i a") ?></td>
				<td class="d-none d-md-table-cell align-middle text-right"><?= $payroll->time_end->format("H:i a") ?></td>
			<?php endif; ?>

			<td class="<?= ( ! $payroll->is_paid ) ? "font-weight-bold" : "" ?> hours-worked-col align-middle text-right">
				<?= number_format($payroll->hours_worked, 2) ?>
			</td>
			<td class="is-paid-col d-none d-md-table-cell align-middle"><?= $this->Bool->prefYes($payroll->is_paid) ?></td>
			<td class="align-middle text-center"><div class="btn-group btn-group-sm-vertical w-100">
				<?= ( $WhoAmI && !$payroll->is_paid ) ? $this->Html->link(
					$this->Pretty->iconMark($payroll->id) . 'Mark',
					['action' => 'edit', $payroll->id],
					[
						'escape' => false,
						'class' => 'w-100 btn btn-sm btn-outline-warning clickMark mark-' . $payroll->id,
						'data-payroll' => $payroll->id
					]
				) : "" ?>
				<?= ( $WhoAmI ) ? $this->Html->link(
					$this->Pretty->iconEdit($payroll->id) . 'Edit',
					['action' => 'edit', $payroll->id],
					['escape' => false, 'class' => 'w-100 btn btn-sm btn-outline-success']
				) : "" ?>
				<?= $this->Form->postLink(
					$this->Pretty->iconDelete($payroll->id) . 'Remove',
					['action' => 'delete', $payroll->id],
					['escape' => false, 'class' => 'w-100 btn btn-sm btn-outline-primary', 'confirm' => 'Are you sure you want to delete payroll?']
				) ?>
			</div></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ( !empty($this->Paginator) ) : ?>
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
<?php endif; ?>

