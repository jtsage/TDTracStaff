<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder[]|\Cake\Collection\CollectionInterface $reminders
 */
?>


<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Reminders</h3>

	<?= $this->HtmlExt->iconBtnLink(
		"calendar-plus", 'Add New Reminder',
		['action' => 'add'],
		['class' => 'btn btn-outline-success w-100 mb-3 btn-lg']
	) ?>
	


	<table cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th scope="col"><?= $this->Paginator->sort('description') ?></th>
				<th scope="col"><?= $this->Paginator->sort('start_time', "Next Run Date") ?></th>
				<th scope="col"><?= $this->Paginator->sort('type') ?></th>
				<th scope="col"><?= $this->Paginator->sort('period') ?></th>
				<th scope="col"><?= $this->Paginator->sort('last_run') ?></th>
				<th scope="col" class="actions"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($reminders as $reminder): ?>
			<tr>
			<td><?= h($reminder->description) ?></td>
				<td><?= h($reminder->start_time) ?></td>
				<td><?= ["Cron Tracker", "Submit Hours Reminder"][$reminder->type] ?></td>
				<td><?= $this->Number->format($reminder->period) ?></td>
				<td><?= h($reminder->last_run) ?></td>
				<td class="actions text-center"><div class="btn-group w-100">
					<?= $this->HtmlExt->iconBtnLink(
						"calendar-multiple-check", 'View',
						['action' => 'view', $reminder->id],
						['class' => 'w-100 btn btn-sm btn-outline-primary']
					) ?>
					<?= $this->HtmlExt->iconBtnLink(
						"file-edit", 'Edit',
						['action' => 'edit', $reminder->id],
						['class' => 'w-100 btn btn-sm btn-outline-success']
					) ?>
					<?= $this->HtmlExt->iconBtnLink(
						"delete", "Remove",
						"#",
						[
							'data-id'      => $reminder->id,
							'data-msg'     => "Are you sure you wish to delete the reminder '" . $reminder->description . "'?",
							'data-control' => 'reminders',
							'class'        => "deleteBtn w-100 btn btn-sm btn-outline-danger"
						]
				) ?>

				</div></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>

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