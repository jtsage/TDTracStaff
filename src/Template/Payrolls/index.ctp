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
				['Total Unpaid', ['class' => 'align-middle font-weight-bold']],
				[' ', ['class' => 'align-middle font-weight-bold']],
				( ( $CONFIG['require-hours'] ) ? [" ", ['class' => 'd-none d-md-table-cell']] : false ),
				( ( $CONFIG['require-hours'] ) ? [" ", ['class' => 'd-none d-md-table-cell']] : false ),
				[number_format($userTotals[$currentUserID]["total_unpaid"],2), ['class' => 'font-weight-bold align-middle text-right']],
				[" ", ['class' => "d-none d-md-table-cell"] ],
				" "
			]),
			array_filter([
				( ( $multiUser ) ? [$currentUserNM, ['class' => 'align-middle', 'style' => "border-bottom-color: #777;"]] : false ),
				['Total', ['class' => 'align-middle font-weight-bold', 'style' => "border-bottom-color: #777;"]],
				[' ', ['class' => 'align-middle font-weight-bold', 'style' => "border-bottom-color: #777;"]],
				( ( $CONFIG['require-hours'] ) ? [" ", ['class' => 'd-none d-md-table-cell', 'style' => "border-bottom-color: #777;"]] : false ),
				( ( $CONFIG['require-hours'] ) ? [" ", ['class' => 'd-none d-md-table-cell', 'style' => "border-bottom-color: #777;"]] : false ),
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

<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4"><?= $mainTitle ?></h3>
	<p class="text-dark"><?= $subTitle ?></p>


<?php
	if ( $this->request->getParam('action') <> "index" && $this->request->getParam('action') <> "unpaid" ) {
		$passed = $this->request->getParam('pass');
		if ( end($passed) == "unpaid" ) {
			$linkie = ["action" => $this->request->getParam('action')];
			array_pop($passed);
			$linkie = array_merge($linkie, $passed);

			echo $this->HtmlExt->iconBtnLink(
				"bookmark", 'View All',
				$linkie,
				['class' => 'btn btn-outline-dark w-100']
			);
		} else {
			$linkie = ["action" => $this->request->getParam('action')];
			$linkie = array_merge($linkie, $passed);
			$linkie[] = "unpaid";
			echo $this->HtmlExt->iconBtnLink(
				'bookmark-check', 'View Unpaid',
				$linkie,
				['class' => 'btn btn-outline-dark w-100']
			);
		}
	}
?>
</div>

<?php if ( $payrolls->count() > 0 ) : ?>
<div class="card rounded border shadow-sm mb-2">

<table id="export_table" class="table table-bordered table-striped mb-0">
<caption class="d-none">TDTracStaff-Payroll</caption>
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
		<?php $unpaidAll = []; ?>
		<?php foreach ($payrolls as $payroll): ?>
		<?php
			if ( ! $payroll->is_paid ) {
				$unpaidAll[] = $payroll->id;
			}
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
				<span class="d-none d-md-inline"><?= $payroll->user->first ?> </span>
				<?= $payroll->user->last ?>
				</a></td>
			<?php endif; ?>
			<td class="align-middle"><a href="/jobs/view/<?= $payroll->job->id ?>" class="text-reset"><?= $payroll->job->name ?></a></td>

			<td class="align-middle text-right">
				<?= $payroll->date_worked->format('\<\s\p\a\n \c\l\a\s\s="\d\-\n\o\n\e \d\-\m\d\-\i\n\l\i\n\e\"\>Y-\<\/\s\p\a\n\>m-d') ?>
			</td>

			<?php if ( $CONFIG['require-hours'] ) : ?>
				<td class="d-none d-md-table-cell align-middle text-right"><?= $payroll->time_start->format("H:i a") ?></td>
				<td class="d-none d-md-table-cell align-middle text-right"><?= $payroll->time_end->format("H:i a") ?></td>
			<?php endif; ?>

			<td class="<?= ( ! $payroll->is_paid ) ? "font-weight-bold" : "" ?> hours-worked-col align-middle text-right">
				<?= number_format($payroll->hours_worked, 2) ?>
			</td>
			<td class="is-paid-col d-none d-md-table-cell align-middle text-right"><?= $this->htmlExt->badgePaid($payroll->is_paid) ?></td>
			<td class="align-middle text-center py-0"><div class="btn-group btn-group-sm-vertical w-100">
				<?= ( $WhoAmI && !$payroll->is_paid ) ? $this->HtmlExt->iconBtnLink(
					"bookmark-plus", 'Mark',
					"#",
					[
						'escape' => false,
						'class' => 'w-100 btn btn-sm btn-outline-warning clickMark mark-' . $payroll->id,
						'data-msg'     => "Are you sure you wish to mark the payroll '" . $payroll->date_worked->format("Y-m-d") . " - " . number_format($payroll->hours_worked, 2) . " hours' as paid?",
						'data-payroll' => $payroll->id
					]
				) : "" ?>
				<?= ( $WhoAmI ) ? $this->HtmlExt->iconBtnLink(
					"file-edit", 'Edit',
					['action' => 'edit', $payroll->id],
					['class' => 'w-100 btn btn-sm btn-outline-success']
				) : "" ?>
				<?= ( $payroll->is_paid ) ? "" : $this->HtmlExt->iconBtnLink(
					"delete", "Remove",
					"#",
					[
						'data-id'      => $payroll->id,
						'data-msg'     => "Are you sure you wish to delete the payroll '" . $payroll->date_worked->format("Y-m-d") . " - " . number_format($payroll->hours_worked, 2) . " hours'?",
						'data-control' => 'payrolls',
						'class'        => "deleteBtn w-100 btn btn-sm btn-outline-danger"
					]
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
<?php if ($WhoAmI) : ?>
<button id="export" data-export="export" class="btn btn-outline-light text-dark btn-sm"><?= $this->HtmlExt->icon("cloud-download") ?> Download view as CSV</button>
<?php endif; ?>
</div>

<?php if ( $isPaged ) : ?>
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
<?php endif; ?>

<?php if ($WhoAmI) : ?>
<div class="card rounded border p-2 shadow-sm">
	<?= $this->Form->create("", ["id" => "markAllForm", "url" => "/payrolls/markAll"]); ?>
	<?php foreach ( $unpaidAll as $thisUnpaid ) {
		echo $this->Form->hidden("unpaidid[]", ["value" => $thisUnpaid]);
	}
	?>
	<?= $this->Form->button($this->HtmlExt->icon("bookmark-off") . __(' Mark Visible Unpaid as Paid'), ["type" => "button", "id" => "markAllBut", "class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end(); ?>
</div>
<?php endif; ?>

<?php else : ?>
	<div class="alert alert-warning shadow-sm" role="alert">No qualifing payroll records found.</div>
<?php endif; ?>

