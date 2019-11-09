<h3><?= __("User List") ?></h3>
<?= $this->Html->link(
	$this->Pretty->iconAdd(__("User")) . "Add New User",
	['action' => 'add'],
	['escape' => false, 'class' => 'btn btn-outline-success btn-lg mb-3 w-100']
) ?>


<div class="users index large-10 medium-9 columns">
	<table class="table table-striped table-bordered">
	<thead>
		<?= $this->Html->tableHeaders([
			$this->Paginator->sort('username', __("E-Mail")),
			$this->Paginator->sort('last', __("Full Name")),
			$this->Paginator->sort('phone', __("Phone")),
			$this->Paginator->sort('is_active', __("Active")),
			$this->Paginator->sort('is_admin', __("Admin"), ['direction' => 'desc']),
			$this->Paginator->sort('last_login_at', __("Last Login"), ['direction' => 'desc']),
			[__('Actions') => ['class' => 'text-center']]
		]); ?>

	</thead>
	<tbody>
	<?php foreach ($users as $user) {
		echo $this->Html->tableCells([
			[
				h($user->username),
				h($user->first) . " " .  h($user->last),
				h($user->phone),
				$this->Bool->prefYes($user->is_active),
				$this->Bool->prefNo($user->is_admin) ,
				$user->last_login_at->i18nFormat(null, $tz),
				[  
					'<div class="btn-group w-100" role="group">' .
					$this->Html->link(
						$this->Pretty->iconView($user->username) . "View",
						['action' => 'view', $user->id],
						['escape' => false, 'class' => 'btn btn-outline-dark btn-sm']
					) . 
					$this->Html->link(
						$this->Pretty->iconLock($user->username) . "Change Pass",
						['action' => 'changepass', $user->id],
						['escape' => false, 'class' => 'btn btn-outline-dark btn-sm']
					) .
					$this->Html->link(
						$this->Pretty->iconEdit($user->username) . "Edit",
						['action' => 'edit', $user->id],
						['escape' => false, 'class' => 'btn btn-outline-success btn-sm']
					) .
					$this->Html->link(
						$this->Pretty->iconPerm($user->username) . "Titles",
						['action' => 'roles', $user->id],
						['escape' => false, 'class' => 'btn btn-outline-info btn-sm']
					) .
					$this->Form->postLink(
						$this->Pretty->iconDelete($user->username) . "Remove",
						['action' => 'delete', $user->id],
						['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-outline-primary btn-sm']
					) .
					'</div>',
					['class' => 'text-center']
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
</div>
