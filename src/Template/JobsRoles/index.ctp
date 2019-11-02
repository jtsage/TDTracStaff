<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JobsRole[]|\Cake\Collection\CollectionInterface $jobsRoles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Jobs Role'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="jobsRoles index large-9 medium-8 columns content">
    <h3><?= __('Jobs Roles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('job_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('number_needed') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobsRoles as $jobsRole): ?>
            <tr>
                <td><?= $this->Number->format($jobsRole->id) ?></td>
                <td><?= $jobsRole->has('job') ? $this->Html->link($jobsRole->job->name, ['controller' => 'Jobs', 'action' => 'view', $jobsRole->job->id]) : '' ?></td>
                <td><?= $jobsRole->has('role') ? $this->Html->link($jobsRole->role->title, ['controller' => 'Roles', 'action' => 'view', $jobsRole->role->id]) : '' ?></td>
                <td><?= $this->Number->format($jobsRole->number_needed) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $jobsRole->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $jobsRole->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $jobsRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobsRole->id)]) ?>
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
