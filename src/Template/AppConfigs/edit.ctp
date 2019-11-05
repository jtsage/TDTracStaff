<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig $appConfig
 */
?>
<div class="appConfigs form large-9 medium-8 columns content">
	<?= $this->Form->create($appConfig) ?>
	<fieldset>
		<legend><?= __('Edit Configuration') ?></legend>
		<?php
			echo $this->Form->control('key_name', ["label" => "Setting Name", "readonly" => "readonly"]);
			echo $this->Form->control('value_short', ["label" => "Setting Description", "readonly" => "readonly"]);
			echo $this->Form->control('value_long', ["label" => "Setting Value", "rows" => 25]);
		?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconSave("") . __('Save Setting'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>
