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

<div id="app" class="blog">
	<div id="app-content">
		<div id="app-sidebar" class="disappear detailsView scroll-container">
			<div id="commentsTabView" class="tab">

			</div>
		</div>

		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('part.add')); ?>

			<div id="emptycontent" class="emptycontent-admin hidden">
				<div class="icon-blog"></div>
				<h2><?php p($l->t('No blog post')); ?></h2>
				<p><?php p($l->t("You didn't post any blog yet")); ?></p>
			</div>
		</div>
	</div>
</div>
