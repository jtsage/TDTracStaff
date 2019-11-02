<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig $appConfig
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $appConfig->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $appConfig->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List App Configs'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="appConfigs form large-9 medium-8 columns content">
    <?= $this->Form->create($appConfig) ?>
    <fieldset>
        <legend><?= __('Edit App Config') ?></legend>
        <?php
            echo $this->Form->control('key_name');
            echo $this->Form->control('value_short');
            echo $this->Form->control('value_long');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
