<h3>Login</h3>
<?= $this->Form->create() ?>
<?= $this->Form->input('username', ['label' => __("E-Mail Address") ]) ?>
<?= $this->Form->input('password', ['label' => __("Password") ]) ?>
<?= $this->Form->button($this->Pretty->iconPower("") . __('Login'), ['class' => 'btn-outline-dark w-100']) ?>
<?= $this->Form->end() ?><br />
<?= $this->Form->postButton($this->Pretty->iconLock("") . __('Forgot Password'), "/users/forgot_password", ['class' => 'w-100 mt-5 btn-outline-danger']) ?>

<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<?= $this->Pretty->helpMeEnd(); ?>