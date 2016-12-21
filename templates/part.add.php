<?php
/**
 * @var \OCP\IL10N $l
 * @var array $_
 */
?>
<form id="new-blog" class="section">
	<h1><?php p($l->t('Write a new blog post')); ?></h1>

	<input type="text" name="subject" id="subject" placeholder="<?php p($l->t('Subject …')); ?>">
	<br>
	<textarea name="text" id="text" placeholder="<?php p($l->t('Blog post …')); ?>"></textarea>
	<br>
	<em>Markdown is supported</em>
	<br>

	<input type="button" id="submit" class="primary" value="<?php p($l->t('Publish')); ?>" name="submit">
	<span id="submit_msg" class="msg"></span>
</form>
