<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<h3>Worker Titles</h3>
<p>Worker titles for on site staff, to be assigned to each job. Multiple workers may share a job title.</p>
<?= $this->Html->link(
	$this->Pretty->iconAdd(__("Title")) . "Add Worker Title",
	['action' => 'add'],
	['escape' => false, 'class' => 'btn btn-outline-success w-100 mb-4 btn-lg']
) ?>

<div class="roles index large-9 medium-8 columns content">
	<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th scope="col"><?= $this->Paginator->sort('sort_order', "Sort") ?></th>
				<th scope="col"><?= $this->Paginator->sort('title') ?></th>
				<th scope="col"><?= $this->Paginator->sort('detail', "Description") ?></th>
				<th scope="col" class="actions text-center"><?= __('Actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($roles as $role): ?>
			<tr>
				<td class="align-middle"><?= h($role->sort_order) ?></td>
				<td class="align-middle"><?= h($role->title) ?></td>
				<td class="align-middle"><?= h($role->detail) ?></td>
				<td class="actions text-center"><div class="w-100 btn-group btn-group-sm-vertical">
					<?= $this->Html->link(
						$this->Pretty->iconView("") . "View Workers",
						['action' => 'view', $role->id],
						['escape' => false, 'class' => 'text-left text-md-center btn btn-outline-dark btn-sm']
					) . 
					$this->Html->link(
						$this->Pretty->iconEdit("") . "Edit",
						['action' => 'edit', $role->id],
						['escape' => false, 'class' => 'text-left text-md-center btn btn-outline-success btn-sm']
					) .
					$this->Form->postLink(
						$this->Pretty->iconDelete("") . "Remove",
						['action' => 'delete', $role->id],
						['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $role->id), 'class' => 'text-left text-md-center btn btn-outline-primary btn-sm']
					) ?>
				</div></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?= $this->Pretty->helpMeStart("Job Titles"); ?>
<p>Use this section to define job titles (roles) for all of the jobs in the system. Note
that the "sort" field is to control what order titles are presented in.</p>
<?= $this->Pretty->helpMeEnd(); ?>