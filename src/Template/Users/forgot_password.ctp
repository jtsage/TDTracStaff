<h3>Send Password Reset E-Mail</h3>
<?= $this->Form->create() ?>
<?= $this->Form->input('username', ['label' => __("E-Mail Address") ]) ?>
<?= $this->Form->button($this->Pretty->iconLock("") . __('Send Reset E-Mail'), ['class' => 'btn-outline-dark w-100']) ?>
<?= $this->Form->end() ?><br />
