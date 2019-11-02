<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JobsRole $jobsRole
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Jobs Role'), ['action' => 'edit', $jobsRole->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Jobs Role'), ['action' => 'delete', $jobsRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobsRole->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Jobs Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Jobs Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="jobsRoles view large-9 medium-8 columns content">
    <h3><?= h($jobsRole->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Job') ?></th>
            <td><?= $jobsRole->has('job') ? $this->Html->link($jobsRole->job->name, ['controller' => 'Jobs', 'action' => 'view', $jobsRole->job->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $jobsRole->has('role') ? $this->Html->link($jobsRole->role->title, ['controller' => 'Roles', 'action' => 'view', $jobsRole->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($jobsRole->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Number Needed') ?></th>
            <td><?= $this->Number->format($jobsRole->number_needed) ?></td>
        </tr>
    </table>
</div>
