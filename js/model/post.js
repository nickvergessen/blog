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
	 * @class OCA.Blog.Model.Post
	 */
	OCA.Blog.Model.Post = OC.Backbone.Model.extend(/** @lends OCA.Blog.Model.Post.prototype */{
		// /**
		//  *
		//  * @returns int UNIX milliseconds timestamp
		//  */
		// getUnixMilliseconds: function() {
		// 	if (_.isUndefined(this.unixMilliseconds)) {
		// 		this.unixMilliseconds = moment(this.get('date')).valueOf();
		// 	}
		// 	return this.unixMilliseconds;
		// },
		//
		// /**
		//  * @returns string E.g. "seconds ago"
		//  */
		// getRelativeDate: function () {
		// 	return OC.Util.relativeModifiedDate(this.getUnixMilliseconds());
		// },
		//
		// /**
		//  * @returns string E.g. "April 26, 2016 10:53 AM"
		//  */
		// getFullDate: function () {
		// 	return OC.Util.formatDate(this.getUnixMilliseconds());
		// }
	});
})();

