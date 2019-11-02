<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersJob[]|\Cake\Collection\CollectionInterface $usersJobs
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Users Job'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usersJobs index large-9 medium-8 columns content">
    <h3><?= __('Users Jobs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('job_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_available') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_scheduled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('note') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersJobs as $usersJob): ?>
            <tr>
                <td><?= $this->Number->format($usersJob->id) ?></td>
                <td><?= $usersJob->has('user') ? $this->Html->link($usersJob->user->print_name, ['controller' => 'Users', 'action' => 'view', $usersJob->user->id]) : '' ?></td>
                <td><?= $usersJob->has('job') ? $this->Html->link($usersJob->job->name, ['controller' => 'Jobs', 'action' => 'view', $usersJob->job->id]) : '' ?></td>
                <td><?= $usersJob->has('role') ? $this->Html->link($usersJob->role->title, ['controller' => 'Roles', 'action' => 'view', $usersJob->role->id]) : '' ?></td>
                <td><?= $this->Number->format($usersJob->is_available) ?></td>
                <td><?= $this->Number->format($usersJob->is_scheduled) ?></td>
                <td><?= h($usersJob->note) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $usersJob->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usersJob->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usersJob->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersJob->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
