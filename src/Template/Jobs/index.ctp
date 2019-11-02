<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job[]|\Cake\Collection\CollectionInterface $jobs
 */
?>

<h3>Job List</h3>
<p>Full list of jobs. Regular users see open, active jobs (upcoming).  Administrators see the full history of jobs.</p>

<div class="jobs index large-9 medium-8 columns content">
	<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th scope="col"><?= $this->Paginator->sort('name') ?></th>
				<th scope="col"><?= $this->Paginator->sort('detail', "Description") ?></th>
				<th scope="col"><?= $this->Paginator->sort('category') ?></th>
				<th scope="col"><?= $this->Paginator->sort('location') ?></th>
				<th scope="col"><?= $this->Paginator->sort('date_start', "Start Date") ?></th>
				<th scope="col">Active / Open</th>
				<th scope="col" class="text-center actions"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($jobs as $job): ?>
			<tr>
				<td><?= h($job->name) ?></td>
				<td><?= h($job->detail) ?></td>
				<td><?= h($job->category) ?></td>
				<?php
					$locHref = "https://www.google.com/maps/search/?api=1&query=";
					$locHref .= urlencode($job->location);
				?>
				<td><a target="_blank" href="<?= $locHref ?>"><?= trim(substr($job->location, 0, 40)) ?>...</a></td>
				
				<td><?= $job->date_start->format("m/d/Y") ?></td>
				
				<td><?= $this->Bool->prefYes($job->is_active) ?> / <?= $this->Bool->prefYes($job->is_open) ?></td>
				
				<td class="actions">
					<?= $this->Html->link(__('View'), ['action' => 'view', $job->id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $job->id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $job->id], ['confirm' => __('Are you sure you want to delete # {0}?', $job->id)]) ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
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
