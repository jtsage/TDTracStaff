<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<h3>Add New Worker Title</h3>
<div class="roles form large-9 medium-8 columns content">
	<?= $this->Form->create($role) ?>
	<fieldset>
		<?php
			echo $this->Form->control('title', ["label" => "Title"]);
			echo $this->Form->control('detail', ["label" => "Description"]);
		?>
	</fieldset>
	<?= $this->Form->button($this->Pretty->iconAdd("") . __('Add Worker Title'), ["class" => "w-100 btn-lg btn-outline-success"]) ?>
	<?= $this->Form->end() ?>
</div>
