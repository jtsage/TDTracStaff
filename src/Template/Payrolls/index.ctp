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
				" ",
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
				" ",
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
				['class' => 'btn btn-outline-dark w-100 mb-2']
			);
		} else {
			$linkie = ["action" => $this->request->getParam('action')];
			$linkie = array_merge($linkie, $passed);
			$linkie[] = "unpaid";
			echo $this->HtmlExt->iconBtnLink(
				'bookmark-check', 'View Unpaid',
				$linkie,
				['class' => 'btn btn-outline-dark w-100 mb-2']
			);
		}
	}
?>

<div class="btn-group w-100">
	<a class="noteclick note-col btn btn-outline-primary" href="#">Show Notes as Column</a>
	<a class="noteclick note-inline btn btn-outline-primary" href="#">Show Notes as Inline</a>
	<a class="noteclick note-none btn btn-outline-primary" href="#">Don't Show Notes</a>
</div>

<script>
	$(".noteclick").on("click", function() {
		if ( $(this).hasClass("note-col") ) {
			$(".noteclick").removeClass("btn-primary").addClass("btn-outline-primary");
			$(".notes-by-col").addClass("d-table-cell").removeClass("d-none");
			$(".notes-by-inline").removeClass("d-inline").addClass("d-none");
			Cookies.set('note-display', 0, { expires: 365 });
		}
		if ( $(this).hasClass("note-inline") ) {
			$(".noteclick").removeClass("btn-primary").addClass("btn-outline-primary");
			$(".notes-by-col").removeClass("d-table-cell").addClass("d-none");
			$(".notes-by-inline").addClass("d-inline").removeClass("d-none");
			Cookies.set('note-display', 1, { expires: 365 });
		}
		if ( $(this).hasClass("note-none") ) {
			$(".noteclick").removeClass("btn-primary").addClass("btn-outline-primary");
			$(".notes-by-col").removeClass("d-table-cell").addClass("d-none");
			$(".notes-by-inline").removeClass("d-inline").addClass("d-none");
			Cookies.set('note-display', 2, { expires: 365 });
		}
		$(this).removeClass("btn-outline-primary").addClass("btn-primary");
		return false;
	});
	$( document ).ready(function() {
		var cook = parseInt(Cookies.get("note-display"),10) || 0;
		switch (cook) {
			case 0:
				$(".notes-by-col").addClass("d-table-cell").removeClass("d-none");
				$(".notes-by-inline").removeClass("d-inline").addClass("d-none");
				$(".note-col").removeClass("btn-outline-primary").addClass("btn-primary");
				break;
			case 1:
				$(".notes-by-col").removeClass("d-table-cell").addClass("d-none");
				$(".notes-by-inline").addClass("d-inline").removeClass("d-none");
				$(".note-inline").removeClass("btn-outline-primary").addClass("btn-primary");
				break;
			case 2:
				$(".notes-by-col").removeClass("d-table-cell").addClass("d-none");
				$(".notes-by-inline").removeClass("d-inline").addClass("d-none");
				$(".note-none").removeClass("btn-outline-primary").addClass("btn-primary");
				break;
		}
	});
</script>
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
			<th scope="col" class="notes-by-col d-table-cell">Notes</th>

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
			<td class="align-middle"><a href="/jobs/view/<?= $payroll->job->id ?>" class="text-reset"><?= $payroll->job->name ?></a>
				<span class="d-inline notes-by-inline"><br><span class="pl-2 small font-italic"><?= ( !empty($payroll->notes) ) ? $payroll->notes : "" ?></span></span>
			</td>
			<td class="notes-by-col d-table-cell">
				<?= ( !empty($payroll->notes) ) ? $payroll->notes : "" ?>
			</td>


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


<?= $this->Pretty->helpMeStart("View Payroll Items"); ?>
<p>This display shows payroll items of the associated user or job.</p>

<p>Unpaid items may be editted by the user that submitted them. Paid items can only be edited by an administrator.</p>

<p>No-one may delete a paid item.</p>

<p>The CSV Export button at the bottom of the display provides an Excel importable file for the current view.</p>

<?= $this->Pretty->helpMeEnd(); ?>

