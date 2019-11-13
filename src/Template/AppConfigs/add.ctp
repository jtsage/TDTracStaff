<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig $appConfig
 */
?>

<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark">Add Configuration Key</h3>
	<p class="text-danger pt-3"><strong>WARNING: </strong>It is intentionally difficult to add new keys.  You can royally screw up the running system by adding values needlessly</p>

	<?= $this->Form->create($appConfig) ?>
	<fieldset>
		<?php
			echo $this->Form->control('key_name', ["label" => "Setting Name"]);
			echo $this->Form->control('value_short', ["required" => "required", "label" => "Setting Description"]);
			echo $this->Form->control('value_long', ["required" => "required", "label" => "Setting Value", "rows" => 25]);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("plus") . " Add Setting", ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
	
</div>


<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<p><strong>WARNING: </strong>It is intentionally difficult to add new keys.  You can royally screw up the running system by adding values needlessly</p>
<?= $this->Pretty->helpMeEnd(); ?>