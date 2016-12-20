<?php
/**
 * @var \OCP\IL10N $l
 * @var array $_
 */
?>
<form id="announce" class="section">
	<h1><?php p($l->t('Write a new blog post')); ?></h1>

	<input type="text" name="subject" id="subject" placeholder="<?php p($l->t('Subject …')); ?>" />
	<br />
	<textarea name="message" id="message" placeholder="<?php p($l->t('Blog post …')); ?>"></textarea>
	<br />

	<input type="button" id="submit_announcement" class="primary" value="<?php p($l->t('Publish')); ?>" name="submit" />
	<span id="announcement_submit_msg" class="msg"></span>
</form>
