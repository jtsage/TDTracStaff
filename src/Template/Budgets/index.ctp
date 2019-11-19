<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Budget[]|\Cake\Collection\CollectionInterface $budgets
 */
?>
<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-0">Job Budgets - Open Jobs</h3>
	<?php foreach ( $openJob as $job ) : ?>
		<?php 
			$budAloc  = array_key_exists($job->id, $budgeTotal) ? $budgeTotal[$job->id] : 0;
			$budAllow = $job->has_budget_total;
			$budPerc  = ( $job->has_budget_total == 0 ) ? 0 : intval(($budAloc / $budAllow) * 100);
			$color = ( $budAllow < $budAloc ) ? "danger" : "success";
		?>
		<?= $this->htmlExt->iconBtnLink(
			"chevron-right-box",
			$job->name . " <span class='badge badge-pill badge-" . $color . "'>" . $budPerc . "%</span>",
			["action" => "view", $job->id],
			["class" => "btn btn-outline-primary w-100 mt-2"]
		) ?>
	<?php endforeach; ?>
</div>

<div class="card p-3 rounded border shadow-sm mb-2">
	<h3 class="text-dark mb-0">Job Budgets - Closed Jobs</h3>
	<?php foreach ( $closeJob as $job ) : ?>
		<?php 
			$budAloc  = array_key_exists($job->id, $budgeTotal) ? $budgeTotal[$job->id] : 0;
			$budAllow = $job->has_budget_total;
			$budPerc  = ( $job->has_budget_total == 0 ) ? 0 : intval(($budAloc / $budAllow) * 100);
			$color = ( $budAllow < $budAloc ) ? "danger" : "success";
		?>
		<?= $this->htmlExt->iconBtnLink(
			"chevron-right-box",
			$job->name . " <span class='badge badge-pill badge-" . $color . "'>" . $budPerc . "%</span>",
			["action" => "view", $job->id],
			["class" => "btn btn-outline-primary w-100 mt-2"]
		) ?>
	<?php endforeach; ?>
</div>

