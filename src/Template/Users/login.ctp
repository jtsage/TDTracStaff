<div class="card p-3 rounded border shadow-sm">

<h3 class="text-dark mb-4">Login</h3>
<?= $this->Form->create(null, ['align' => [
	'sm' => [
		'left'   => 6,
		'middle' => 6,
		'right'  => 12
	],
	'md' => [
		'left'   => 3,
		'middle' => 9,
		'right'  => 0
	]
]]) ?>
<?= $this->Form->input('username', ['label' => __("E-Mail Address") ]) ?>
<?= $this->Form->input('password', ['label' => __("Password") ]) ?>
<?= $this->Form->button($this->HtmlExt->icon("login") . __('Login'), ['class' => 'btn-outline-primary w-100']) ?>
<?= $this->Form->end() ?><br />
<?= $this->Form->postButton($this->HtmlExt->icon("lock-question") . __('Forgot Password'), "/users/forgot_password", ['class' => 'w-100 mt-5 btn-outline-danger']) ?>

</div>


<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<?= $this->Pretty->helpMeEnd(); ?>