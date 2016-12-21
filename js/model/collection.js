/**
 * @copyright Copyright (c) 2016, Joas Schilling <coding@schilljs.com>
 * @author Joas Schilling <coding@schilljs.com>
 * @license GNU AGPL version 3 or any later version
 */
(function() {
	if (!OCA.Blog) {
		OCA.Blog = {};
	}

	if (!OCA.Blog.Model) {
		OCA.Blog.Model = {};
	}


	/**
	 * @class OCA.Blog.Model.Collection
	 */
	OCA.Blog.Model.Collection = OC.Backbone.Collection.extend(/** @lends OCA.Blog.Model.Collection.prototype */{

		_blog: null,
		_getMore: true,
		model: OCA.Blog.Model.Post,

		setBlog: function(blog) {
			this._blog = blog;
		},

		/**
		 * @param data
		 * @param response
		 * @returns {Array}
		 */
		parse: function(data, response) {
			this._saveHeaders(response.xhr.getAllResponseHeaders());

			if (response.xhr.status === 304) {
				// No activities found
				return [];
			}

			return data;
		},

		/**
		 * Read the X-Blog-Last-Given and Link headers
		 * @param headers
		 */
		_saveHeaders: function(headers) {
			var self = this;
			this._getMore = false;

			headers = headers.split("\n");
			_.each(headers, function (header) {
				var parts = header.split(':');
				if (parts[0].toLowerCase() === 'link') {
					self._getMore = parts[1].trim();
				}
			});
		},

		url: function() {
			var url = '',
				query = {
					format: 'json'
				};

			if (this._getMore === true) {
				url = OC.generateUrl('/apps/blog/api/v1') + '/' + this._blog;
			} else if (this._getMore !== false) {
				url = this._getMore;
			} else {
				return OC.generateUrl('/apps/blog/api/v1') + '/' + this._blog;
			}

			url += '?' + OC.buildQueryString(query);
			return url;
		}
	});
})();

