<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4"><?= __("Mail Queue List") ?></h3>
	<p class='text-dark'>E-Mail Outbox for the application</p>
</div>

<div class="card rounded border shadow-sm mb-2">
<table class="table table-striped w-100 table-bordered mb-0">
	<thead>
	<tr>
		<th scope="col">Template</th>
		<th scope="col">Recipient</th>
		<th scope="col">Subject</th>
		<th scope="col">Queued At</th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
		<?php foreach ($mailQueues as $mailQueue): ?>
		<tr>
			<td><?= h($mailQueue->template) ?></td>
			<td><?= h($mailQueue->toUser) ?></td>
			<td><?= h($mailQueue->subject) ?></td>
			<td><?= $mailQueue->created_at->i18nFormat(null, $CONFIG['time-zone']) ?></td>
			<td class="actions"><div class="btn-group btn-group-sm-vertical w-100" role="group">
				<?= $this->HtmlExt->iconBtnLink(
					"account-details",  "View",
					['action' => 'view', $mailQueue->id],
					['class' => 'btn btn-outline-primary btn-sm text-left text-md-center w-100']
				) ?>
				<?= $this->HtmlExt->iconBtnLink(
					"delete", "Remove",
					"#",
					[
						'data-id'      => $mailQueue->id,
						'data-msg'     => "Are you sure you wish to delete outgoing mail?",
						'data-control' => 'mail-queues',
						'class'        => "deleteBtn w-100 text-left text-md-center btn btn-outline-danger btn-sm"
					]
				) ?>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>

<div class="card rounded border p-2 shadow-sm">
	<div class="paginator">
		<ul class="pagination justify-content-center mb-2">
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
		</ul>
		<p class="text-center text-muted small m-0"><?= $this->Paginator->counter() ?></p>
	</div>
</div>
