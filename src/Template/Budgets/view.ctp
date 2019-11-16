<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget[]|\Cake\Collection\CollectionInterface $budgets
 */
?>
<div class="card rounded px-3 pt-3 border shadow-sm mb-2">
	<div class="row">
		<?php 
			$budAloc  = array_key_exists($job->id, $budgeTotal) ? $budgeTotal[$job->id] : 0;
			$budAllow = $job->has_budget_total;
			$budPerc  = ( $job->has_budget_total == 0 ) ? 0 : intval(($budgeTotal[$job->id] / $job->has_budget_total) * 100);
		?>
		<div class="col-12 p-0 text-dark border-bottom">
			<h3 class="p-0 m-0 mb-3 ml-2">Budget - <?= $job->category ?> - <?= $job->name ?></h3>
		</div>
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
	<?= $this->HtmlExt->iconBtnLink(
		"credit-card-plus", 'Add Budget Item',
		['controller' => 'budgets', 'action' => 'add', $job->id],
		['class' => 'btn w-100 my-2 btn-outline-success']
	) ?>
</div>

<div class="card rounded border shadow-sm mb-2">
	<table id="export_table" class="table table-striped table-bordered mb-0 w-100">
		<thead>
			<tr>
				<th scope="col">Date</th>
				<th scope="col">Category</th>
				<th scope="col">Vendor</th>
				<th scope="col">Description</th>
				<th scope="col">Amount</th>
				<th scope="col">Added By</th>
				<th scope="col" class="text-center"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($budgets as $budget): ?>
			<tr>
				<td class="align-middle"><?= $budget->date->format("Y-m-d") ?></td>
				<td class="align-middle"><?= h($budget->category) ?></td>
				<td class="align-middle"><?= h($budget->vendor) ?></td>
				<td class="align-middle"><?= h($budget->detail) ?></td>
				<td class="align-middle text-right">$<?= number_format($budget->amount,2) ?></td>
				<td class="align-middle"><?= $this->Html->link($budget->user->last . ", " . $budget->user->first, ['controller' => 'Users', 'action' => 'view', $budget->user->id]) ?></td>
				<td class="actions text-center">
					<?= ($WhoAmI || $this->request->getSession()->read('Auth.User.id') == $budget->user->id ) ? $this->HtmlExt->iconBtnLink(
						"delete", "Remove",
						"#",
						[
							'data-id'      => $budget->id,
							'data-msg'     => "Are you sure you wish to delete the budget '" . $budget->date->format("Y-m-d") . " - $" . number_format($budget->amount, 2) . "'?",
							'data-control' => 'budgets',
							'class'        => "deleteBtn w-100 btn btn-sm btn-outline-danger"
						]
					) : "" ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<button id="export" data-export="export" class="btn btn-outline-light text-dark btn-sm"><?= $this->HtmlExt->icon("cloud-download") ?> Download view as CSV</button>
</div>
