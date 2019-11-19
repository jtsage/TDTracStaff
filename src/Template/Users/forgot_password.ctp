<div class="card p-3 rounded border shadow-sm">

<h3 class="text-dark mb-4">Send Password Reset E-Mail</h3>
<?= $this->Form->create() ?>
<?= $this->Form->input('username', ['label' => __("E-Mail Address") ]) ?>
<?= $this->Form->button($this->HtmlExt->icon("lock-question") . __('Send Reset E-Mail'), ['class' => 'btn-outline-dark w-100']) ?>
<?= $this->Form->end() ?><br />
</div>
<?= $this->Pretty->helpMeStart("Password Retrieval"); ?>
<p>Use this form to send a password recovery e-mail to your account.  Enter your e-mail address.</p>
<?= $this->Pretty->helpMeEnd(); ?>