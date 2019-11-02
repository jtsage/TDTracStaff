<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JobsRole $jobsRole
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Jobs Roles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="jobsRoles form large-9 medium-8 columns content">
    <?= $this->Form->create($jobsRole) ?>
    <fieldset>
        <legend><?= __('Add Jobs Role') ?></legend>
        <?php
            echo $this->Form->control('job_id', ['options' => $jobs]);
            echo $this->Form->control('role_id', ['options' => $roles]);
            echo $this->Form->control('number_needed');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
