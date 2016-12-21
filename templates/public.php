<?php
/**
 * @var array $_
 * @var \OCP\IL10N $l
 */
script('oc-backbone-webdav');
script('blog', [
	'blog',
	'model/post',
	'model/collection',
]);
style('blog', [
	'blog',
]);
?>

<div id="app" data-blog="<?php p($_['blog']) ?>">
	<div id="app-content" class="participants-1">

		<header>
			<div id="header" class="spreed-public">
				<a href="<?php print_unescaped(link_to('', 'index.php')); ?>" title="" id="nextcloud">
					<div class="logo-icon svg"></div>
				</a>
				<div class="header-appname-container">
					<h1 class="header-appname">
						<?php p($_['name']); ?>
					</h1>
				</div>
			</div>
		</header>

		<div id="app" class="blog">
			<div id="app-content">
				<div id="app-content-wrapper">
					<div id="emptycontent" class="emptycontent-admin hidden">
						<div class="icon-blog"></div>
						<h2><?php p($l->t('No blog post')); ?></h2>
						<p><?php p($l->t("You didn't post any blog yet")); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

