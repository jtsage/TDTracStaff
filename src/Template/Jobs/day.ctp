<h3>Day View</h3>
<h4><?= $date->format("F j, Y"); ?></h4>

<div class="btn-group w-100 mb-3">
	<a href="<?= $dateView['prevLink'] ?>" class="btn btn-outline-dark w-50"><?= $this->Pretty->iconPrev("") ?> Previous Day</a>
	<a href="<?= $dateView['nextLink'] ?>" class="btn btn-outline-dark w-50">Next Day <?= $this->Pretty->iconNext("") ?> </a>
</div>

<div class="w-100 mb-2" style="border-bottom: 1px dashed #ccc"><h4>Jobs</h4></div>
<?php foreach ( $jobs as $job ) : ?>

<?php 
	$isInt = false;
	$isSch = false;

	foreach ( $job->users_both as $stats ) {
		if ( $stats->_joinData->is_available ) { $isInt = true; }
		if ( $stats->_joinData->is_scheduled ) { $isSch = true; }
	}

?>
<a class="btn btn-outline-<?= ( $isSch ? "success" : ( $isInt ? "warning" : "dark" ) ) ?> w-100 mb-1" href="/jobs/view/<?= $job->id ?>"><?= $job->name ?></a>

<?php endforeach; ?>

<div class="mt-3">
	<div class="w-100 rounded-pill p-1 mb-1 border border-success text-center text-success">You are scheduled for this event</div>
	<div class="w-100 rounded-pill p-1 mb-1 border border-warning text-center text-warning">You are available for this event</div>
</div>

<?= $this->Pretty->helpMeStart("Job Calendar - Daily"); ?>

<p>This display shows a calendar of all jobs.  Click on a job listing for additional detail. (Mobile will bring up a day view).</p>

<p>Please refer to the bottom of the page for details on the color code used.</p>

<?= $this->Pretty->helpMeEnd(); ?>