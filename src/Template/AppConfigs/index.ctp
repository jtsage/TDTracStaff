<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig[]|\Cake\Collection\CollectionInterface $appConfigs
 */
?>
<h3><?= __("Application Config") ?></h3>

<div class="appConfigs index large-9 medium-8 columns content">
	<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th scope="col"><?= $this->Paginator->sort('key_name', "Setting Name") ?></th>
				<th scope="col"><?= $this->Paginator->sort('value_short', "Description") ?></th>
				<th scope="col" class="actions"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($appConfigs as $appConfig): ?>
			<tr>
				<td><?= h($appConfig->key_name) ?></td>
				<td><?= h($appConfig->value_short) ?></td>
				<td class="actions"><div class="btn-group w-100" role="group">
					<?= $this->Html->link(
						$this->Pretty->iconView($appConfig->key_name) . "View",
						['action' => 'view', $appConfig->id],
						['escape' => false, 'class' => 'btn btn-outline-dark btn-sm']
					) ?> 
					<?= $this->Html->link(
						$this->Pretty->iconEdit($appConfig->key_name) . "Edit",
						['action' => 'edit', $appConfig->id],
						['escape' => false, 'class' => 'btn btn-outline-success btn-sm']
					) ?>
				</div></td>
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
