<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users Jobs'), ['controller' => 'UsersJobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Users Job'), ['controller' => 'UsersJobs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="roles view large-9 medium-8 columns content">
    <h3><?= h($role->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($role->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($role->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Detail') ?></th>
            <td><?= h($role->detail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($role->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($role->updated_at) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Jobs') ?></h4>
        <?php if (!empty($role->jobs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Detail') ?></th>
                <th scope="col"><?= __('Location') ?></th>
                <th scope="col"><?= __('Category') ?></th>
                <th scope="col"><?= __('Date Start') ?></th>
                <th scope="col"><?= __('Date End') ?></th>
                <th scope="col"><?= __('Time String') ?></th>
                <th scope="col"><?= __('Is Active') ?></th>
                <th scope="col"><?= __('Is Open') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($role->jobs as $jobs): ?>
            <tr>
                <td><?= h($jobs->id) ?></td>
                <td><?= h($jobs->name) ?></td>
                <td><?= h($jobs->detail) ?></td>
                <td><?= h($jobs->location) ?></td>
                <td><?= h($jobs->category) ?></td>
                <td><?= h($jobs->date_start) ?></td>
                <td><?= h($jobs->date_end) ?></td>
                <td><?= h($jobs->time_string) ?></td>
                <td><?= h($jobs->is_active) ?></td>
                <td><?= h($jobs->is_open) ?></td>
                <td><?= h($jobs->created_at) ?></td>
                <td><?= h($jobs->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Jobs', 'action' => 'view', $jobs->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Jobs', 'action' => 'edit', $jobs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Jobs', 'action' => 'delete', $jobs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($role->users)): ?>
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
            <?php foreach ($role->users as $users): ?>
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
        <h4><?= __('Related Users Jobs') ?></h4>
        <?php if (!empty($role->users_jobs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Job Id') ?></th>
                <th scope="col"><?= __('Role Id') ?></th>
                <th scope="col"><?= __('Is Available') ?></th>
                <th scope="col"><?= __('Is Scheduled') ?></th>
                <th scope="col"><?= __('Note') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($role->users_jobs as $usersJobs): ?>
            <tr>
                <td><?= h($usersJobs->id) ?></td>
                <td><?= h($usersJobs->user_id) ?></td>
                <td><?= h($usersJobs->job_id) ?></td>
                <td><?= h($usersJobs->role_id) ?></td>
                <td><?= h($usersJobs->is_available) ?></td>
                <td><?= h($usersJobs->is_scheduled) ?></td>
                <td><?= h($usersJobs->note) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UsersJobs', 'action' => 'view', $usersJobs->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UsersJobs', 'action' => 'edit', $usersJobs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UsersJobs', 'action' => 'delete', $usersJobs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersJobs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
