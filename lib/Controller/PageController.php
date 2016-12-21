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


use OC\HintException;
use OCA\Blog\AppInfo\Application;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\IUser;
use OCP\IUserManager;

class PageController extends Controller {

	/** @var IUserManager */
	protected $userManager;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param IUserManager $userManager
	 */
	public function __construct(string $appName, IRequest $request, IUserManager $userManager) {
		parent::__construct($appName, $request);

		$this->userManager = $userManager;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function index(): TemplateResponse {
		return new TemplateResponse(Application::APP_NAME, 'main');
	}

	/**
	 * @PublicPage
	 * @NoCSRFRequired
	 *
	 * @param string $blog
	 * @return TemplateResponse
	 * @throws HintException
	 */
	public function publicPage(string $blog): TemplateResponse {

		$user = $this->userManager->get($blog);
		if (!$user instanceof IUser) {
			throw new HintException('Blog does not exist');
		}

		return new TemplateResponse(Application::APP_NAME, 'public', [
			'blog' => $blog,
			'name' => $this->getBlogName($user->getDisplayName()),
		], 'base');
	}

	protected function getBlogName(string $username): string {
		if (substr($username, -1) === 's') {
			return $username . '´ blog'; // TODO translate
		}
		return $username . '´s blog'; // TODO translate
	}
}
