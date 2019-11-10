<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>

<h3><?= h($role->title) ?></h3>
<p><?= $role->detail ?></p>

<div class='btn-group w-100 mb-3'>
<?= $this->Html->link(
	$this->Pretty->iconEdit("") . "Edit Title",
	['action' => 'edit', $role->id],
	['escape' => false, 'class' => 'btn btn-outline-success mb-4']
) ?>
</div>


<h4><?= __('Qualified Users') ?></h4>
<?php if (!empty($role->users)): ?>
<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
	<tr>
		<th scope="col"><?= __('Username') ?></th>
		<th scope="col"><?= __('Full Name') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	<?php foreach ($role->users as $users): ?>
	<tr>
		<td><?= h($users->username) ?></td>
		<td><?= h($users->first) ?> <?= h($users->last) ?></td>
		<td class="actions"><div class="btn-group w-100">
			<?= $this->Html->link(
				$this->Pretty->iconView($users->username) . "View",
				['controller' => 'Users', 'action' => 'view', $users->id],
				['escape' => false, 'class' => 'btn btn-outline-dark btn-sm']
			) . 
			$this->Html->link(
				$this->Pretty->iconPerm($users->username) . "Titles",
				['controller' => 'Users', 'action' => 'roles', $users->id],
				['escape' => false, 'class' => 'btn btn-outline-info btn-sm']
			) ?>
		</div></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>


<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<p>View help at the Job Title Configuration list screen instead.</p>
<?= $this->Pretty->helpMeEnd(); ?>
