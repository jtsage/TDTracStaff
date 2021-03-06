<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4"><?= __("User List") ?></h3>
	<p class='text-dark'>This display shows all of the registered users for the running application.</p>
	<?= $this->HtmlExt->iconBtnlink(
		"account-plus", "Add New User",
		['action' => 'add'],
		['class' => 'btn btn-outline-success btn-lg mb-3 w-100']
	) ?>
</div>

<div class="card rounded border shadow-sm mb-2">

<table class="table table-striped w-100 table-bordered mb-0">
<thead>
	<?= $this->Html->tableHeaders([
		[ $this->Paginator->sort('last', __("Full Name")) => ["class" => "align-middle"] ],
		[ "Phone / E-Mail" => ["class" => "d-none d-md-table-cell align-middle "] ],
		[ $this->Paginator->sort('is_active', __("Active")) . "<br>" . $this->Paginator->sort('is_budget', __("Budget")) . "<br>" . $this->Paginator->sort('is_admin', __("Admin"), ['direction' => 'desc']) => ["class" => "align-middle d-none d-md-table-cell"] ],
		[ $this->Paginator->sort('last_login_at', __("Last Login"), ['direction' => 'desc']) => ["class" => "align-middle d-none d-md-table-cell"] ],
		[__('Actions') => ['class' => 'text-center align-middle ', 'style' => 'min-width: 150px;']]
	]); ?>

</thead>
<tbody>
<?php foreach ($users as $user) {
	$roleDiv = "<div class='d-none d-md-block' style='margin-left: 65px'>";
	foreach ( $user->roles as $role ) {
		$roleDiv .= '<div class="badge badge-primary">' . $role->title . '</div> ';
	}
	$roleDiv .= "</div>";
	echo $this->Html->tableCells([
		[
			[ $this->HtmlExt->gravatar($user->username,65,"d-block d-md-inline mx-auto mx-md-0") . " <strong>" . h($user->last) . ", " .  h($user->first) . "</strong>" . $roleDiv, ["class" => "align-middle text-dark text-center text-md-left"] ],
			[ $this->HtmlExt->hyphenNBR($user->phone) . "<br>" . $user->username, ["class" => "align-middle d-none d-md-table-cell"] ],
			[ $this->HtmlExt->badgeActive($user->is_active) . "<br>" . $this->HtmlExt->badgeBudget($user->is_budget) . "<br>" . $this->HtmlExt->badgeAdmin($user->is_admin) , ["class" => "align-middle d-none d-md-table-cell"] ],
			[ $user->last_login_at->i18nFormat(null, $tz), ["class" => "align-middle d-none d-md-table-cell"] ],
			[  
				'<div class="btn-group-vertical w-100" role="group">' .
				$this->HtmlExt->iconBtnLink(
					"account-details",  "View",
					['action' => 'view', $user->id],
					['class' => 'btn btn-outline-primary btn-sm text-left']
				) . 
				$this->HtmlExt->iconBtnLink(
					"cash", "Payroll Hours",
					['controller' => 'payrolls', 'action' => 'user', $user->id],
					['class' => 'btn btn-outline-primary btn-sm text-left']
				) . 
				$this->HtmlExt->iconBtnLink(
					"message-alert", "Send SMS",
					['action' => 'sms', $user->id],
					['class' => 'btn btn-outline-info btn-sm text-left']
				) . 
				$this->HtmlExt->iconBtnLink(
					"account-key", "Change Pass",
					['action' => 'changepass', $user->id],
					['class' => 'btn btn-outline-warning btn-sm text-left']
				) .
				$this->HtmlExt->iconBtnLink(
					"account-edit", "Edit",
					['action' => 'edit', $user->id],
					['class' => 'btn btn-outline-success btn-sm text-left']
				) .
				$this->HtmlExt->iconBtnLink(
					"account-star", "Titles",
					['action' => 'roles', $user->id],
					['class' => 'btn btn-outline-purp btn-sm text-left']
				) .
				$this->HtmlExt->iconBtnLink(
					"delete", "Remove",
					"#",
					[
						'data-id'      => $user->id,
						'data-msg'     => "Are you sure you wish to delete the title '" . $user->first . " " . $user->last . "'?",
						'data-control' => 'users',
						'class'        => "deleteBtn w-100 text-left btn btn-outline-danger btn-sm"
					]
				) .
				'</div>',
				['class' => 'w-25 text-center']
			]
		]
	]);
} ?>

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

<?= $this->Pretty->helpMeStart("User List"); ?>
<p>A full list of the users of the system. Only administrators may view this display.</p>
<?= $this->Pretty->helpMeEnd(); ?>