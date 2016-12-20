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

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\Mapper;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

class PostMapper extends Mapper {

	/** @var string */
	protected $table;

	/**
	 * @param IDBConnection $db
	 */
	public function __construct(IDBConnection $db) {
		$this->table = 'blogs';
		parent::__construct($db, $this->table, Post::class);
	}

	/**
	 * @param int $id
	 * @return Post
	 * @throws DoesNotExistException
	 */
	public function getById(int $id): Post {
		$query = $this->db->getQueryBuilder();

		$query->select('*')
			->from($this->table)
			->where($query->expr()->eq('id', $query->createNamedParameter($id, IQueryBuilder::PARAM_INT)));

		$result = $query->execute();
		$row = $result->fetch();
		$result->closeCursor();

		if (!$row) {
			throw new DoesNotExistException('Post could not be found by id');
		}

		return $this->mapRowToEntity($row);
	}

	/**
	 * @param string $blog
	 * @return Post[]
	 */
	public function getByBlog(string $blog): array {
		$query = $this->db->getQueryBuilder();

		$query->select('*')
			->from($this->table)
			->where($query->expr()->eq('blog', $query->createNamedParameter($blog)))
			->orderBy('date', 'DESC')
			->setMaxResults(10);

		$result = $query->execute();
		$posts = [];
		while ($row = $result->fetch()) {
			$posts[] = $this->mapRowToEntity($row);
		}
		$result->closeCursor();

		return $posts;
	}
}
