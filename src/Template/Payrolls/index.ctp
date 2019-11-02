<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payroll[]|\Cake\Collection\CollectionInterface $payrolls
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payroll'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payrolls index large-9 medium-8 columns content">
    <h3><?= __('Payrolls') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_worked') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time_start') ?></th>
                <th scope="col"><?= $this->Paginator->sort('time_end') ?></th>
                <th scope="col"><?= $this->Paginator->sort('hours_worked') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_paid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('job_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payrolls as $payroll): ?>
            <tr>
                <td><?= h($payroll->id) ?></td>
                <td><?= h($payroll->date_worked) ?></td>
                <td><?= h($payroll->time_start) ?></td>
                <td><?= h($payroll->time_end) ?></td>
                <td><?= $this->Number->format($payroll->hours_worked) ?></td>
                <td><?= h($payroll->is_paid) ?></td>
                <td><?= $payroll->has('user') ? $this->Html->link($payroll->user->print_name, ['controller' => 'Users', 'action' => 'view', $payroll->user->id]) : '' ?></td>
                <td><?= $payroll->has('job') ? $this->Html->link($payroll->job->name, ['controller' => 'Jobs', 'action' => 'view', $payroll->job->id]) : '' ?></td>
                <td><?= h($payroll->created_at) ?></td>
                <td><?= h($payroll->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $payroll->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payroll->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payroll->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payroll->id)]) ?>
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
