/**
 * @copyright Copyright (c) 2016, Joas Schilling <coding@schilljs.com>
 * @author Joas Schilling <coding@schilljs.com>
 * @license GNU AGPL version 3 or any later version
 */

(function() {
	if (!OCA.Blog) {
		/**
		 * @namespace
		 */
		OCA.Blog = {};
	}

	OCA.Blog.App = {
		posts: {},
		ignoreScroll: 0,
		$container: null,
		$content: null,
		lastLoadedPost: 0,
		sevenDaysMilliseconds: 7 * 24 * 3600 * 1000,
		commentsTabView: null,

		_compiledTemplate: null,
		_handlebarTemplate: '<div class="section">' +
				'<h2>{{{subject}}}</h2>' +
				// 	'<span class="has-tooltip live-relative-timestamp" data-timestamp="{{timestamp}}" title="{{dateFormat}}">{{dateRelative}}</span>' +
				// 	'<span>{{{author}}}</span>' +
				// 	'{{#if isAdmin}}' +
				// 		'<span class="visibility has-tooltip" title="{{{visibilityString}}}">' +
				// 			'{{#if visibilityEveryone}}' +
				// 				'<img src="' + OC.imagePath('core', 'places/link') + '">' +
				// 			'{{else}}' +
				// 				'<img src="' + OC.imagePath('core', 'places/contacts-dark') + '">' +
				// 			'{{/if}}' +
				// 		'</span>' +
				// 	'{{/if}}' +
				// 	'{{#if comments}}' +
				// 		'<span class="comment-details" data-count="{{num_comments}}">{{comments}}</span>' +
				// 	'{{/if}}' +
				// 	'{{#if isAdmin}}' +
				// 		'<span class="delete-link has-tooltip" title="' + t('announcementcenter', 'Delete') + '">' +
				// 			'<a href="#" data-announcement-id="{{{announcementId}}}">' +
				// 				'<img class="svg" src="' + OC.imagePath('core', 'actions/delete') + '" alt=""/>' +
				// 			'</a>' +
				// 		'</span>' +
				// 		'{{#if hasNotifications}}' +
				// 		'<span class="mute-link has-tooltip" title="' + t('announcementcenter', 'Remove notifications') + '">' +
				// 			'<a href="#" data-announcement-id="{{{announcementId}}}">' +
				// 				'<img class="svg" src="' + OC.imagePath('announcementcenter', 'notifications-off.svg') + '" alt=""/>' +
				// 			'</a>' +
				// 		'</span>' +
				// 		'{{/if}}' +
				// 	'{{/if}}' +
				// '{{#if message}}' +
				// 	'<br /><br /><p>{{{message}}}</p>' +
				// '{{/if}}' +
			'</div>' +
			'<hr />',

		init: function() {
			this.$container = $('#app-content-wrapper');
			this.$content = $('#app-content');

			this.collection = new OCA.Blog.Model.Collection();
			this.collection.setBlog(oc_current_user);

			// this.collection.on('request', this._onRequest, this);
			// this.collection.on('sync', this._onEndRequest, this);
			// this.collection.on('error', this._onError, this);
			// this.collection.on('add', this._onAddModel, this);

			this.collection.reset();
			this.collection.fetch();
		},


		/**
		 * @param {OCA.Blog.Model.Post} post
		 * @return {Object}
		 */
		_formatItem: function(post) {
			return {
				subject: post.get('subject')
			};
		},

		_template: function(params) {
			if (!this._compiledTemplate) {
				this._compiledTemplate = Handlebars.compile(this._handlebarTemplate);
			}

			return this._compiledTemplate(params);
		},

		_onAddModel: function(model, collection, options) {
			var $el = $(this._template(this._formatItem(model)));

			if (!_.isUndefined(options.at) && collection.length > 1) {
				this.$container.find('li').eq(options.at).before($el);
			} else {
				this.$container.append($el);
			}

			this._postRenderItem($el);
		},

		_postRenderItem: function($el) {
			$el.find('.avatar').each(function() {
				var element = $(this);
				if (element.data('user-display-name')) {
					element.avatar(element.data('user'), 21, undefined, false, undefined, element.data('user-display-name'));
				} else {
					element.avatar(element.data('user'), 21);
				}
			});
			$el.find('.has-tooltip').tooltip({
				placement: 'bottom'
			});
		},

		_onError: function() {
			console.error('Error while trying to load the blog posts');
		},

		_onRequest: function() {
			console.debug('Starting request');
		},

		_onEndRequest: function() {
			console.debug('End of request');
		}
	};

})();

$(document).ready(function() {
	OCA.Blog.App.init();
});
