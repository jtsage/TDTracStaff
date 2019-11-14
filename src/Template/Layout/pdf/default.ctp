<html>
	<head>
		<style>
			/** Define the margins of your page **/
			@page {
				margin: 75px 25px 50px;
			}
			body { font-family: DejaVu Sans; font-size: 10pt; }
			h1, h2, h3, h4, h5, h6 { font-family: Times; }
			header {
				position: fixed;
				top: -65px;
				left: 0px;
				right: 0px;
				height: 750px;

				/** Extra personal styles **/
				text-align: center;
			}
			
			.list { width: 100%; }
			.list td { padding: 3px; border: 1px solid #333; margin:0; }
			.list th { padding: 3px; border: 1px solid #333; margin:0; background-color: rgb(224,235,255); }

			footer {
				position: fixed;
				bottom: -20px; 
				left: 0px; 
				right: 0px;
				height: 20px; 
				color: #666;

				/** Extra personal styles **/
				text-align: center;
			}

			.page-number {
				text-align: center;
			}

			.page-number:before {
				content: "Page: " counter(page);
			}

			#watermark {
				position: fixed;
				font-size: 150px;
				top: 35%;
				width: 100%;
				text-align: center;
				opacity: .07;
				transform: rotate(-45deg);
				transform-origin: 50% 50%;
				z-index: 1000;
			}
		</style>
		<title><?= $pdfTitle ?></title>
	</head>
	<body>
		<!-- Define header and footer blocks before your content -->
		<header>
			<h1>TDTracStaff :: <?=$CONFIG['long-name'] ?></h1>
		</header>

		<footer>
				<?= date("l, F jS, Y") ?> - TDTracStaff::<?=$CONFIG['long-name']?></span>
		</footer>

		<?php if ( isset($pdfWaterMark) && !empty($pdfWaterMark) ) : ?>
		<div id="watermark">
			<?= $pdfWaterMark ?>
		</div>
		<?php endif; ?>

		<main>
			<?= $this->fetch('content') ?>
		</main>
	</body>
</html>