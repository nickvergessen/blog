<?php
/**
 * @copyright Copyright (c) 2016, Joas Schilling <coding@schilljs.com>
 *
 * @author Joas Schilling <coding@schilljs.com>
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

namespace OCA\Blog\Controller;

use OCA\Blog\Model\Post;
use OCA\Blog\Model\PostMapper;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Controller;
use OCP\IL10N;
use OCP\IRequest;
use OCP\IUser;
use OCP\IUserManager;
use OCP\IUserSession;

class ApiController extends Controller {

	/** @var IL10N */
	protected $l;

	/** @var PostMapper */
	protected $postMapper;

	/** @var IUserManager */
	protected $userManager;

	/** @var IUserSession */
	protected $userSession;

	/** @var string[] */
	protected $displayNames;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param IL10N $l
	 * @param PostMapper $postMapper
	 * @param IUserManager $userManager
	 * @param IUserSession $userSession
	 */
	public function __construct($appName,
								IRequest $request,
								IL10N $l,
								PostMapper $postMapper,
								IUserManager $userManager,
								IUserSession $userSession) {
		parent::__construct($appName, $request);

		$this->l = $l;
		$this->postMapper = $postMapper;
		$this->userManager = $userManager;
		$this->userSession = $userSession;
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param string $blog
	 * @return JSONResponse
	 */
	public function get(string $blog): JSONResponse {
		$posts = $this->postMapper->getByBlog($blog);

		if (empty($posts)) {
			return new JSONResponse([], Http::STATUS_NOT_FOUND);
		}

		$data = array_map(function(Post $post) {
			return $this->postToArray($post);
		}, $posts);

		return new JSONResponse($data);
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param string $blog
	 * @param string $subject
	 * @param string $text
	 * @return JSONResponse
	 */
	public function create(string $blog, string $subject, string $text): JSONResponse {
		$user = $this->userSession->getUser();
		if ($user->getUID() !== $blog) {
			return new JSONResponse([], Http::STATUS_FORBIDDEN);
		}

		$post = new Post();
		$post->setBlog($user->getUID());
		$post->setUser($user->getUID());
		$post->setSubject($subject);
		$post->setSlug($this->slugify($subject));
		$post->setText($text);
		$post->setDate(new \DateTime());

		if ($post->getSlug() === '') {
			return new JSONResponse([], Http::STATUS_BAD_REQUEST);
		}

		$this->postMapper->insert($post);

		return new JSONResponse($this->postToArray($post));
	}

	/**
	 * @NoAdminRequired
	 *
	 * @param int $postId
	 * @return JSONResponse
	 */
	public function delete(int $postId): JSONResponse {
		try {
			$post = $this->postMapper->getById($postId);
		} catch (DoesNotExistException $e) {
			return new JSONResponse([], Http::STATUS_FORBIDDEN);
		}

		$user = $this->userSession->getUser();
		if ($user->getUID() !== $post->getBlog()) {
			return new JSONResponse([], Http::STATUS_FORBIDDEN);
		}

		$this->postMapper->delete($post);

		return new JSONResponse();
	}

	/**
	 * @param string $string
	 * @return string
	 */
	protected function slugify(string $string): string {
		$string = strtolower($string);
		$string = str_replace(['ö', 'ä', 'ü', 'ß'], ['oe', 'ae', 'ue', 'ss'], $string);
		$string = preg_replace('/[^a-z0-9]+/', '-', $string);
		$string = preg_replace('/-{2,}/', '-', $string);
		return trim($string, '-');
	}


	/**
	 * @param Post $post
	 * @return array
	 */
	protected function postToArray(Post $post): array {
		return [
			'id' => $post->getId(),
			'blog' => $post->getBlog(),
			'user' => $post->getUser(),
			'displayName' => $this->getDisplayName($post->getUser()),
			'date' => $post->getDate(),
			'subject' => $post->getSubject(),
			'slug' => $post->getSlug(),
			'text' => $post->getText(),
		];
	}

	/**
	 * @param string $uid
	 * @return string
	 */
	protected function getDisplayName(string $uid): string {
		if (!isset($this->displayNames[$uid])) {
			$user = $this->userManager->get($uid);
			if ($user instanceof IUser) {
				$this->displayNames[$uid] = $user->getDisplayName();
			} else {
				$this->displayNames[$uid] = $uid;
			}
		}

		return $this->displayNames[$uid];
	}
}
