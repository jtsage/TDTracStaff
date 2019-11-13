<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>

<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4"><?= h($role->title) ?></h3>
	<p><?= $role->detail ?></p>

	<?= $this->HtmlExt->iconBtnLink(
		"playlist-edit", "Edit Title",
		['action' => 'edit', $role->id],
		['class' => 'btn btn-outline-success w-100']
	) ?>
</div>

<div class="card p-3 rounded border shadow-sm mb-2">
	<h4 class="text-dark mb-4"><?= __('Qualified Users') ?></h4>

<?php if (!empty($role->users)): ?>
<table class="table table-striped table-bordered" cellpadding="0" cellspacing="0">
	<tr>
		<th class="d-none d-md-table-cell" scope="col"><?= __('Username') ?></th>
		<th scope="col"><?= __('Full Name') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	<?php foreach ($role->users as $users): ?>
	<tr>
		<td class="align-middle d-none d-md-table-cell"><?= h($users->username) ?></td>
		<td class="align-middle"><?= h($users->first) ?> <?= h($users->last) ?></td>
		<td class="actions"><div class="btn-group btn-group-sm-vertical w-100">
			<?= $this->HtmlExt->iconBtnLink(
				"account-details" , "View",
				['controller' => 'Users', 'action' => 'view', $users->id],
				['class' => 'btn btn-outline-dark btn-sm w-100']
			) . 
			$this->HtmlExt->iconBtnLink(
				"account-star" , "Titles",
				['controller' => 'Users', 'action' => 'roles', $users->id],
				['class' => 'btn btn-outline-info btn-sm w-100']
			) ?>
		</div></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>
</div>

<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<p>View help at the Job Title Configuration list screen instead.</p>
<?= $this->Pretty->helpMeEnd(); ?>
