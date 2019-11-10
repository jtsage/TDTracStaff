<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user, ['data-toggle' => 'validator', 'autocomplete' => 'off']) ?>
    <fieldset>
        <legend><?= __('Register as new') ?></legend>
        <?php
            echo $this->Form->input('username', ['label' => __("E-Mail Address")]);
            echo $this->Form->input('password', ['label' => 'Password', 'data-minlength' => 6]);
            echo $this->Form->input('first', ['label' => __("First Name")]);
            echo $this->Form->input('last', ['label' => __("Last Name")]);
	    echo $this->Form->input('print_name', ['label' => __("Print Name")]);
	    echo '<small id="emailHelp" class="form-text text-muted mb-3">How you wish your name to appear in programs / print uses</small>';
        ?>
    </fieldset>
    <?= $this->Form->button(__('Add'), ['class' => 'btn-default']) ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<?= $this->Pretty->helpMeEnd(); ?>
