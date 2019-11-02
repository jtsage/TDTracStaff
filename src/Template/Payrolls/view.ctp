<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payroll $payroll
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payroll'), ['action' => 'edit', $payroll->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payroll'), ['action' => 'delete', $payroll->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payroll->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payrolls'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payroll'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="payrolls view large-9 medium-8 columns content">
    <h3><?= h($payroll->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($payroll->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $payroll->has('user') ? $this->Html->link($payroll->user->print_name, ['controller' => 'Users', 'action' => 'view', $payroll->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Job') ?></th>
            <td><?= $payroll->has('job') ? $this->Html->link($payroll->job->name, ['controller' => 'Jobs', 'action' => 'view', $payroll->job->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Hours Worked') ?></th>
            <td><?= $this->Number->format($payroll->hours_worked) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Worked') ?></th>
            <td><?= h($payroll->date_worked) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Time Start') ?></th>
            <td><?= h($payroll->time_start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Time End') ?></th>
            <td><?= h($payroll->time_end) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($payroll->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($payroll->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Paid') ?></th>
            <td><?= $payroll->is_paid ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
