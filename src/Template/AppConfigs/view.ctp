<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AppConfig $appConfig
 */
?>
<h3><?= h($appConfig->key_name) ?></h3>
<?= $this->Html->link(
	$this->Pretty->iconEdit(__("")) . "Edit this Config",
	['action' => 'edit', $appConfig->id],
	['escape' => false, 'class' => 'btn btn-outline-success btn-lg mb-3 w-100']
) ?>

<div class="appConfigs view large-9 medium-8 columns content">
	<table class="table vertical-table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($appConfig->key_name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Description') ?></th>
			<td><?= h($appConfig->value_short) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Value') ?></th>
			<td><?= $this->Text->autoParagraph(h($appConfig->value_long)); ?></td>
		</tr>
	</table>
</div>
