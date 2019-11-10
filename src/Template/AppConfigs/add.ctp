<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig $appConfig
 */
?>

<div class="appConfigs form large-9 medium-8 columns content">
	<?= $this->Form->create($appConfig) ?>
	<fieldset>
		<legend><?= __('Add Configuration') ?></legend>
		<?php
			echo $this->Form->control('key_name', ["label" => "Setting Name"]);
			echo $this->Form->control('value_short', ["label" => "Setting Description"]);
			echo $this->Form->control('value_long', ["label" => "Setting Value", "rows" => 25]);
		?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconAdd("") . __('Add Setting'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>
<p><strong>WARNING: </strong>It is intentionally difficult to add new keys.  You can royally screw up the running system by adding values needlessly</p>

<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<p><strong>WARNING: </strong>It is intentionally difficult to add new keys.  You can royally screw up the running system by adding values needlessly</p>
<?= $this->Pretty->helpMeEnd(); ?>