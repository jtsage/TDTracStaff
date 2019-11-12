<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payroll[]|\Cake\Collection\CollectionInterface $payrolls
 */
?>
<?php 
	function makeTotal($currentUserID, $currentUserNM, $userTotals, $multiUser, $CONFIG, $userCountsUnpaidOnly) {
		$table = [
			array_filter([
				( ( $multiUser ) ? [$currentUserNM, ['class' => 'align-middle']] : false ),
				['Total Unpaid', ['colspan' => 2, 'class' => 'align-middle font-weight-bold']],
				( ( $CONFIG['require-hours'] ) ? [" ", ['class' => 'd-none d-md-table-cell', 'colspan' => 2]] : false ),
				[number_format($userTotals[$currentUserID]["total_unpaid"],2), ['class' => 'font-weight-bold align-middle text-right']],
				[" ", ['class' => "d-none d-md-table-cell"] ],
				" "
			]),
			array_filter([
				( ( $multiUser ) ? [$currentUserNM, ['class' => 'align-middle', 'style' => "border-bottom-color: #777;"]] : false ),
				$tableRow2[] = ['Total', ['colspan' => 2, 'class' => 'align-middle font-weight-bold', 'style' => "border-bottom-color: #777;"]],
				( ( $CONFIG['require-hours'] ) ? [" ", ['class' => 'd-none d-md-table-cell', 'colspan' => 2, 'style' => "border-bottom-color: #777;"]] : false ),
				[number_format($userTotals[$currentUserID]["total_worked"],2), ['class' => 'font-weight-bold font-italic align-middle text-right', 'style' => "border-bottom-color: #777;"]],
				[" ", ['class' => "d-none d-md-table-cell", 'style' => "border-bottom-color: #777;"] ],
				[" ", ['style' => "border-bottom-color: #777;"] ]
			]),
		];
		if ( $userCountsUnpaidOnly ) {
			array_pop($table);
			return $table;
		} else {
			return $table;
		}
	}
?>

<h3><?= $mainTitle ?></h3>
<p><?= $subTitle ?></p>

<?php
	if ( $this->request->getParam('action') <> "index" && $this->request->getParam('action') <> "unpaid" ) {
		$passed = $this->request->getParam('pass');
		if ( end($passed) == "unpaid" ) {
			$linkie = ["action" => $this->request->getParam('action')];
			array_pop($passed);
			$linkie = array_merge($linkie, $passed);

			echo $this->Html->link(
				$this->Pretty->iconUnpaid("") . 'View All',
				$linkie,
				['escape' => false, 'class' => 'btn btn-outline-dark w-100 mb-3']
			);
		} else {
			$linkie = ["action" => $this->request->getParam('action')];
			$linkie = array_merge($linkie, $passed);
			$linkie[] = "unpaid";
			echo $this->Html->link(
				$this->Pretty->iconUnpaid("") . 'View Unpaid',
				$linkie,
				['escape' => false, 'class' => 'btn btn-outline-dark w-100 mb-3']
			);
		}
	}
?>

<?php if ( $payrolls->count() > 0 ) : ?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<?php if ( $multiUser ) : ?>
				<th scope="col">User</th>
			<?php endif; ?>
			<th scope="col">Job</th>

			<th scope="col" class="text-center">Date</th>

			<?php if ( $CONFIG['require-hours'] ) : ?>
				<th class="text-center d-none d-md-table-cell" scope="col">Start Time</th>
				<th class="text-center d-none d-md-table-cell" scope="col">End Time</th>
			<?php endif; ?>

			<th scope="col" class="text-center">Hours</th>
			<th class="text-center d-none d-md-table-cell" scope="col">Paid?</th>
			<th scope="col" class="text-center"><?= __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $currentUserID = ""; $currentUserNM = "" ?>
		<?php foreach ($payrolls as $payroll): ?>
		<?php
			if ( $userCounts ) {
				if ( $currentUserID <> $payroll->user->id ) {
					if ( $currentUserID != "" ) {
						echo $this->Html->tableCells(
							makeTotal($currentUserID, $currentUserNM, $userTotals, $multiUser, $CONFIG, $userCountsUnpaidOnly),
							['class' => 'table-danger'],
							['class' => 'table-success'],
							false,
							false
						);
					}
					$currentUserID = $payroll->user->id;
					$currentUserNM = "<span class='d-none d-md-inline'>" . $payroll->user->first . "</span> " . $payroll->user->last;
				}
			}
		?>
		<tr>
			<?php if ( $multiUser ) : ?>
				<td class="align-middle"><a href="/users/view/<?= $payroll->user->id ?>" class="text-reset">
				<span class="d-none d-md-inline"><?= $payroll->user->first ?></span>
				<?= $payroll->user->last ?>
				</a></td>
			<?php endif; ?>
			<td class="align-middle"><a href="/jobs/view/<?= $payroll->job->id ?>" class="text-reset"><?= $payroll->job->name ?></a></td>

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
			<td class="is-paid-col d-none d-md-table-cell align-middle text-right"><?= $this->Bool->prefYes($payroll->is_paid) ?></td>
			<td class="align-middle text-center py-0"><div class="btn-group btn-group-sm-vertical w-100">
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
		<?php 
			if ( $userCounts ) {
				echo $this->Html->tableCells(
					makeTotal($currentUserID, $currentUserNM, $userTotals, $multiUser, $CONFIG, $userCountsUnpaidOnly),
					['class' => 'table-danger'],
					['class' => 'table-success'],
					false,
					false
				);
			}
		?>
	</tbody>
</table>

<?php if ( $isPaged ) : ?>
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

<?php else : ?>
	<div class="alert alert-primary" role="alert">No qualifing payroll records found.</div>
<?php endif; ?>

