<div class="card p-3 rounded border shadow-sm mb-2">
	<div class='btn-group btn-group-sm-vertical w-100'>
	<?= $this->HtmlExt->iconBtnlink(
		"cash", "View Payroll",
		['controller' => 'payrolls', 'action' => 'user', $user->id],
		['class' => 'text-left text-md-center w-100 btn btn-outline-primary']
	) ?>
	<?= $this->HtmlExt->iconBtnlink(
		"account-edit", (( $WhoAmI ) ? "Edit User" : "Edit Profile"),
		['action' => 'edit', $user->id],
		['class' => 'text-left text-md-center w-100 btn btn-outline-success']
	) ?>
	<?= $this->HtmlExt->iconBtnlink(
		"account-key", "Change Password",
		['action' => 'changepass', $user->id],
		['class' => 'text-left text-md-center w-100 btn btn-outline-warning']
	) ?>
	<?= ( $WhoAmI ) ? $this->HtmlExt->iconBtnlink(
		"account-star", "Change Titles",
		['action' => 'roles', $user->id],
		['class' => 'text-left text-md-center w-100 btn btn-outline-purp']
	) : "" ?>
	</div>
</div>

<div class="card p-3 rounded border shadow-sm">
	
	<h3 class="text-dark"><?= h($user->first) . " " . h($user->last) ?></h3>
	<div class="row">
		<div class="col-md-2">
			<?= $this->HtmlExt->gravatar($user->username,150) ?>
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-4">
					<dl class="m-0 mb-2"><dt>Username</dt><dd class="m-0 ml-3"><?= $user->username ?></dd></dl>
					<dl class="m-0 mb-2"><dt>Full Name</dt><dd class="m-0 ml-3"><?= $user->first . " " . $user->last ?></dd></dl>
					<dl class="m-0 mb-2"><dt>Phone Number</dt><dd class="m-0 ml-3"><?= $user->phone ?></dd></dl>
				</div>
				<div class="col-md-4">
					<dl class="m-0 mb-2"><dt>Last Login At</dt><dd class="m-0 ml-3"><?= $user->last_login_at->i18nFormat("EEEE, MMMM d, YYYY @ h:mm a", $tz) ?></dd></dl>
					<dl class="m-0 mb-2"><dt>User Added On</dt><dd class="m-0 ml-3"><?= $user->created_at->i18nFormat("EEEE, MMMM d, YYYY @ h:mm a", $tz) ?></dd></dl>
					<dl class="m-0 mb-2"><dt>Last Updated At</dt><dd class="m-0 ml-3"><?= $user->updated_at->i18nFormat("EEEE, MMMM d, YYYY @ h:mm a", $tz) ?></dd></dl>
				</div>
				<div class="col-md-4">
					<dl class="m-0 mb-2"><dt>Active User?</dt><dd class="m-0 ml-3"><?= $this->HtmlExt->badgeActive($user->is_active) ?></dd></dl>
					<dl class="m-0 mb-2"><dt>Expired Password?</dt><dd class="m-0 ml-3"><?= $this->HtmlExt->badgePass($user->is_password_expired) ?></dd></dl>
					<dl class="m-0 mb-2"><dt>Administrator?</dt><dd class="m-0 ml-3"><?= $this->HtmlExt->badgeAdmin($user->is_admin) ?></dd></dl>
					<dl class="m-0 mb-2"><dt>Budget User?</dt><dd class="m-0 ml-3"><?= $this->HtmlExt->badgeBudget($user->is_budget) ?></dd></dl>
				</div>
			</div>
		</div>
	</div>
	
	<h5 class="text-dark">Training Profile</h5>
	<div class="pl-3">
		<?php foreach ( $user->roles as $role ) : ?>
			<div class="badge badge-primary"><?= $role->title ?></div>
		<?php endforeach; ?>
	</div>

	<h5 class="text-dark mt-3 mb-1">iCalendar (ics) Link</h5>
	<div class="pl-3 text-info"><?= $CONFIG['server-name'] ?>/icals/user/<?= $user->id ?>/<?= $CONFIG['calendar-api-key'] ?>/user.ics</div>
</div>

<?= $this->Pretty->helpMeStart("User View"); ?>
<p>This shows all of the known detail about a user.</p>
<?= $this->Pretty->helpMeEnd(); ?>
