<div class="users view large-10 medium-9 columns">
	<h3><?= h($user->first) . " " . h($user->last) ?></h3>
	<div class='btn-group w-100 mb-3'>
	<?= $this->Html->link(
		$this->Pretty->iconEdit($user->username) . "Edit User",
		['action' => 'edit', $user->id],
		['escape' => false, 'class' => 'btn btn-outline-dark']
	) ?>
	<?= $this->Html->link(
		$this->Pretty->iconLock($user->username) . "Change Password",
		['action' => 'changepass', $user->id],
		['escape' => false, 'class' => 'btn btn-outline-dark']
	) ?>
	<?= ( $WhoAmI ) ? $this->Html->link(
		$this->Pretty->iconPerm($user->username) . "Change Titles",
		['action' => 'roles', $user->id],
		['escape' => false, 'class' => 'btn btn-outline-info']
	) : "" ?>
	</div>
	<div class="row">
		<div class="col-md-4">
			<h4><span class="badge badge-primary"><?= __('Username') ?></span></h4>
			<p><?= h($user->username) ?></p>
			<h4><span class="badge badge-primary"><?= __('Full Name') ?></span></h4>
			<p><?= h($user->first) ?> <?= h($user->last) ?></p>
		</div>
		<div class="col-md-4">
			<h4><span class="badge badge-warning"><?= __('Last Login At') ?></span></h4>
			<p><?= $user->last_login_at->i18nFormat(null, $tz); ?></p>
			<h4><span class="badge badge-warning"><?= __('User Created At') ?></span></h4>
			<p><?= $user->created_at->i18nFormat(null, $tz); ?></p>
			<h4><span class="badge badge-warning"><?= __('Last Update At') ?></span></h4>
			<p><?= $user->updated_at->i18nFormat(null, $tz); ?></p>
		</div>
		<div class="col-md-4">
			<h4><span class="badge badge-success"><?= __('Active User?') ?></span></h4>
			<p><?= $this->Bool->prefYes($user->is_active) ?></p>
			<h4><span class="badge badge-success"><?= __('Expired Password?') ?></span></h4>
			<p><?= $this->Bool->prefNo($user->is_password_expired); ?></p>
			<h4><span class="badge badge-success"><?= __('E-Mail Verified?') ?></span></h4>
			<p><?= $this->Bool->prefYes($user->is_verified); ?></p>
			<h4><span class="badge badge-success"><?= __('Administrator?') ?></span></h4>
			<p><?= $this->Bool->prefNo($user->is_admin); ?></p>
		</div>
	</div>
	<div class="row">
		<h4><span class="badge badge-danger"><?= __('Assigned Titles') ?></span></h4><br />
		<ul class="list-group w-100">
			<?php foreach ( $user->roles as $role ) : ?>
				<li class="list-group-item"><?= $role->title ?> <small><em><?= $role->detail ?></em></small></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
