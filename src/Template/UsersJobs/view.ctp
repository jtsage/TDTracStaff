<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersJob $usersJob
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Users Job'), ['action' => 'edit', $usersJob->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Users Job'), ['action' => 'delete', $usersJob->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersJob->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users Jobs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Users Job'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="usersJobs view large-9 medium-8 columns content">
    <h3><?= h($usersJob->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $usersJob->has('user') ? $this->Html->link($usersJob->user->print_name, ['controller' => 'Users', 'action' => 'view', $usersJob->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Job') ?></th>
            <td><?= $usersJob->has('job') ? $this->Html->link($usersJob->job->name, ['controller' => 'Jobs', 'action' => 'view', $usersJob->job->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $usersJob->has('role') ? $this->Html->link($usersJob->role->title, ['controller' => 'Roles', 'action' => 'view', $usersJob->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= h($usersJob->note) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($usersJob->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Available') ?></th>
            <td><?= $this->Number->format($usersJob->is_available) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Scheduled') ?></th>
            <td><?= $this->Number->format($usersJob->is_scheduled) ?></td>
        </tr>
    </table>
</div>
