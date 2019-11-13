<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-4">Edit Worker Title</h3>

	<?= $this->Form->create($role) ?>
	<fieldset>
		<?php
			echo $this->Form->control('title', ["label" => "Title"]);
			echo $this->Form->control('detail', ["label" => "Description"]);
			echo $this->Form->control('sort_order', ["label" => "Sort"]);
		?>
	</fieldset>
	<?= $this->Form->button($this->HtmlExt->icon("content-save") . __('Save Worker Title'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>

<?= $this->Pretty->helpMeStart("Topic Unavailable"); ?>
<p>View help at the Job Title Configuration list screen instead.</p>
<?= $this->Pretty->helpMeEnd(); ?>