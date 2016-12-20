<?php
/**
 * @copyright Copyright (c) 2016 Joas Schilling <coding@schilljs.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Blog\Model;


use OCP\AppFramework\Db\Entity;

/**
 * Class Post
 *
 * @package OCA\Blog\Model
 *
 * @method void setBlog(string $blog)
 * @method string getBlog()
 * @method void setUser(string $user)
 * @method string getUser()
 * @method void setDate(\DateTime $date)
 * @method \DateTime getDate()
 * @method void setSubject(string $subject)
 * @method string getSubject()
 * @method void setSlug(string $slug)
 * @method string getSlug()
 * @method void setText(string $text)
 * @method string getText()
 */
class Post extends Entity {

	/** @var string */
	public $blog;

	/** @var string */
	public $user;

	/** @var \DateTime */
	public $date;

	/** @var string */
	public $subject;

	/** @var string */
	public $slug;

	/** @var string */
	public $text;

}
