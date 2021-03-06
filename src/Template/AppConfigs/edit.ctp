<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig $appConfig
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark">Edit Configuration Value</h3>
	<?= $this->Form->create($appConfig) ?>
	<fieldset>
		<?php
			echo $this->Form->control('key_name', ["label" => "Setting Name", "readonly" => "readonly"]);
			echo $this->Form->control('value_short', ["required" => "required", "label" => "Setting Description", "readonly" => "readonly"]);
			echo $this->Form->control('value_long', ["required" => "required", "label" => "Setting Value", "rows" => 25]);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("content-save") . " Save Setting", ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>


<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<p>View help at the Application Configuration list screen instead.</p>
<?= $this->Pretty->helpMeEnd(); ?>