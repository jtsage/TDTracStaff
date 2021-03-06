<?php $this->extend('../Layout/TwitterBootstrap/signin'); ?>

<?= $this->Form->create($article, ['class' => 'form-signin text-center']) ?>
<?= $this->Html->image('BootstrapUI.baked-with-cakephp.svg', ['class' => 'mb-4', 'width' => '250']) ?>
<h1 class="h3 mb-3 font-weight-normal"><?= __('Please sign in') ?></h1>
<?= $this->Form->label('email', __('Email address'), ['class' => 'sr-only']) ?>
<?= $this->Form->email('email', ['placeholder' => __('Email address'), 'autofocus']) ?>
<?= $this->Form->label('password', __('Password'), ['class' => 'sr-only']) ?>
<?= $this->Form->password('password', ['placeholder' => __('Password')]) ?>
<?= $this->Form->control('remember-me', ['type' => 'checkbox']) ?>
<?= $this->Form->submit(__('Sign in'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>
<p class="mt-5 mb-3 text-muted">© <?= date('Y') ?></p>
<?= $this->Form->end() ?>
