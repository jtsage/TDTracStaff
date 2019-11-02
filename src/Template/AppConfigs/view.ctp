<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig $appConfig
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit App Config'), ['action' => 'edit', $appConfig->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete App Config'), ['action' => 'delete', $appConfig->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appConfig->id)]) ?> </li>
        <li><?= $this->Html->link(__('List App Configs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New App Config'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="appConfigs view large-9 medium-8 columns content">
    <h3><?= h($appConfig->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($appConfig->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Key Name') ?></th>
            <td><?= h($appConfig->key_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Value Short') ?></th>
            <td><?= h($appConfig->value_short) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Value Long') ?></h4>
        <?= $this->Text->autoParagraph(h($appConfig->value_long)); ?>
    </div>
</div>
