<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>
<h3>Job List</h3>
<p>Full list of jobs. Regular users see open, active jobs (upcoming).  Administrators see the full history of jobs.</p>

<div class="jobs view large-9 medium-8 columns content">
	<h3><?= h($job->name) ?></h3>
	<table class="vertical-table">
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= h($job->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($job->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Detail') ?></th>
			<td><?= h($job->detail) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Location') ?></th>
			<td><?= h($job->location) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Category') ?></th>
			<td><?= h($job->category) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Time String') ?></th>
			<td><?= h($job->time_string) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Date Start') ?></th>
			<td><?= h($job->date_start) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Date End') ?></th>
			<td><?= h($job->date_end) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created At') ?></th>
			<td><?= h($job->created_at) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Updated At') ?></th>
			<td><?= h($job->updated_at) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Is Active') ?></th>
			<td><?= $job->is_active ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Is Open') ?></th>
			<td><?= $job->is_open ? __('Yes') : __('No'); ?></td>
		</tr>
	</table>
	<div class="related">
		<h4><?= __('Related Roles') ?></h4>
		<?php if (!empty($job->roles)): ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th scope="col"><?= __('Id') ?></th>
				<th scope="col"><?= __('Title') ?></th>
				<th scope="col"><?= __('Detail') ?></th>
				<th scope="col"><?= __('Created At') ?></th>
				<th scope="col"><?= __('Updated At') ?></th>
				<th scope="col" class="actions"><?= __('Actions') ?></th>
			</tr>
			<?php foreach ($job->roles as $roles): ?>
			<tr>
				<td><?= h($roles->id) ?></td>
				<td><?= h($roles->title) ?></td>
				<td><?= h($roles->detail) ?></td>
				<td><?= h($roles->created_at) ?></td>
				<td><?= h($roles->updated_at) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['controller' => 'Roles', 'action' => 'view', $roles->id]) ?>
					<?= $this->Html->link(__('Edit'), ['controller' => 'Roles', 'action' => 'edit', $roles->id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roles->id)]) ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>
	</div>
	<div class="related">
		<h4><?= __('Related Users') ?></h4>
		<?php if (!empty($job->users)): ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th scope="col"><?= __('Id') ?></th>
				<th scope="col"><?= __('Username') ?></th>
				<th scope="col"><?= __('Password') ?></th>
				<th scope="col"><?= __('First') ?></th>
				<th scope="col"><?= __('Last') ?></th>
				<th scope="col"><?= __('Is Active') ?></th>
				<th scope="col"><?= __('Is Password Expired') ?></th>
				<th scope="col"><?= __('Is Admin') ?></th>
				<th scope="col"><?= __('Is Verified') ?></th>
				<th scope="col"><?= __('Last Login At') ?></th>
				<th scope="col"><?= __('Created At') ?></th>
				<th scope="col"><?= __('Updated At') ?></th>
				<th scope="col"><?= __('Reset Hash') ?></th>
				<th scope="col"><?= __('Reset Hash Time') ?></th>
				<th scope="col"><?= __('Verify Hash') ?></th>
				<th scope="col" class="actions"><?= __('Actions') ?></th>
			</tr>
			<?php foreach ($job->users as $users): ?>
			<tr>
				<td><?= h($users->id) ?></td>
				<td><?= h($users->username) ?></td>
				<td><?= h($users->password) ?></td>
				<td><?= h($users->first) ?></td>
				<td><?= h($users->last) ?></td>
				<td><?= h($users->is_active) ?></td>
				<td><?= h($users->is_password_expired) ?></td>
				<td><?= h($users->is_admin) ?></td>
				<td><?= h($users->is_verified) ?></td>
				<td><?= h($users->last_login_at) ?></td>
				<td><?= h($users->created_at) ?></td>
				<td><?= h($users->updated_at) ?></td>
				<td><?= h($users->reset_hash) ?></td>
				<td><?= h($users->reset_hash_time) ?></td>
				<td><?= h($users->verify_hash) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
					<?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>
	</div>
	<div class="related">
		<h4><?= __('Related Payrolls') ?></h4>
		<?php if (!empty($job->payrolls)): ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th scope="col"><?= __('Id') ?></th>
				<th scope="col"><?= __('Date Worked') ?></th>
				<th scope="col"><?= __('Time Start') ?></th>
				<th scope="col"><?= __('Time End') ?></th>
				<th scope="col"><?= __('Hours Worked') ?></th>
				<th scope="col"><?= __('Is Paid') ?></th>
				<th scope="col"><?= __('User Id') ?></th>
				<th scope="col"><?= __('Job Id') ?></th>
				<th scope="col"><?= __('Created At') ?></th>
				<th scope="col"><?= __('Updated At') ?></th>
				<th scope="col" class="actions"><?= __('Actions') ?></th>
			</tr>
			<?php foreach ($job->payrolls as $payrolls): ?>
			<tr>
				<td><?= h($payrolls->id) ?></td>
				<td><?= h($payrolls->date_worked) ?></td>
				<td><?= h($payrolls->time_start) ?></td>
				<td><?= h($payrolls->time_end) ?></td>
				<td><?= h($payrolls->hours_worked) ?></td>
				<td><?= h($payrolls->is_paid) ?></td>
				<td><?= h($payrolls->user_id) ?></td>
				<td><?= h($payrolls->job_id) ?></td>
				<td><?= h($payrolls->created_at) ?></td>
				<td><?= h($payrolls->updated_at) ?></td>
				<td class="actions">
					<?= $this->Html->link(__('View'), ['controller' => 'Payrolls', 'action' => 'view', $payrolls->id]) ?>
					<?= $this->Html->link(__('Edit'), ['controller' => 'Payrolls', 'action' => 'edit', $payrolls->id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['controller' => 'Payrolls', 'action' => 'delete', $payrolls->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payrolls->id)]) ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>
	</div>
</div>
