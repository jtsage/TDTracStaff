<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payroll $payroll
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $payroll->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $payroll->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Payrolls'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payrolls form large-9 medium-8 columns content">
    <?= $this->Form->create($payroll) ?>
    <fieldset>
        <legend><?= __('Edit Payroll') ?></legend>
        <?php
            echo $this->Form->control('date_worked');
            echo $this->Form->control('time_start');
            echo $this->Form->control('time_end');
            echo $this->Form->control('hours_worked');
            echo $this->Form->control('is_paid');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('job_id', ['options' => $jobs]);
            echo $this->Form->control('created_at');
            echo $this->Form->control('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
