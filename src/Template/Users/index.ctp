<h3><?= __("User List") ?></h3>
<?= $this->Html->link(
	$this->Pretty->iconAdd(__("User")) . "Add New User",
	['action' => 'add'],
	['escape' => false, 'class' => 'btn btn-outline-success btn-lg mb-3 w-100']
) ?>



<table class="table table-striped w-100 table-bordered">
<thead>
	<?= $this->Html->tableHeaders([
		[ $this->Paginator->sort('username', __("E-Mail")) => ["class" => "d-none d-md-table-cell"] ],
		$this->Paginator->sort('last', __("Full Name")),
		[ $this->Paginator->sort('phone', __("Phone")) => ["class" => "d-none d-md-table-cell"] ],
		[ $this->Paginator->sort('is_active', __("Active")) => ["class" => "d-none d-md-table-cell"] ],
		[ $this->Paginator->sort('is_admin', __("Admin"), ['direction' => 'desc']) => ["class" => "d-none d-md-table-cell"] ],
		[ $this->Paginator->sort('last_login_at', __("Last Login"), ['direction' => 'desc']) => ["class" => "d-none d-md-table-cell"] ],
		[__('Actions') => ['class' => 'text-center', 'style' => 'min-width: 150px;']]
	]); ?>

</thead>
<tbody>
<?php foreach ($users as $user) {
	echo $this->Html->tableCells([
		[
			[ h($user->username), ["class" => "align-middle d-none d-md-table-cell"] ],
			[ h($user->first) . " " .  h($user->last), ["class" => "align-middle"] ],
			[ h($user->phone), ["class" => "align-middle d-none d-md-table-cell"] ],
			[ $this->Bool->prefYes($user->is_active), ["class" => "align-middle d-none d-md-table-cell"] ],
			[ $this->Bool->prefNo($user->is_admin) , ["class" => "align-middle d-none d-md-table-cell"] ],
			[ $user->last_login_at->i18nFormat(null, $tz), ["class" => "align-middle d-none d-md-table-cell"] ],
			[  
				'<div class="btn-group btn-group-sm-vertical w-100" role="group">' .
				$this->Html->link(
					$this->Pretty->iconView($user->username) . "View",
					['action' => 'view', $user->id],
					['escape' => false, 'class' => 'btn btn-outline-dark btn-sm text-left text-md-center']
				) . 
				$this->Html->link(
					$this->Pretty->iconLock($user->username) . "Change Pass",
					['action' => 'changepass', $user->id],
					['escape' => false, 'class' => 'btn btn-outline-dark btn-sm text-left text-md-center']
				) .
				$this->Html->link(
					$this->Pretty->iconEdit($user->username) . "Edit",
					['action' => 'edit', $user->id],
					['escape' => false, 'class' => 'btn btn-outline-success btn-sm text-left text-md-center']
				) .
				$this->Html->link(
					$this->Pretty->iconPerm($user->username) . "Titles",
					['action' => 'roles', $user->id],
					['escape' => false, 'class' => 'btn btn-outline-info btn-sm text-left text-md-center']
				) .
				$this->Form->postLink(
					$this->Pretty->iconDelete($user->username) . "Remove",
					['action' => 'delete', $user->id],
					['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-outline-primary btn-sm text-left text-md-center']
				) .
				'</div>',
				['class' => 'w-25 text-center']
			]
		]
	]);
} ?>

</tbody>
</table>

	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
		</ul>
		<p><?= $this->Paginator->counter() ?></p>
	</div>

