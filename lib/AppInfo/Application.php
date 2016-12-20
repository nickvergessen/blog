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

namespace OCA\Blog\AppInfo;

use OCP\AppFramework\App;

class Application extends App {

	const APP_NAME = 'blog';

	public function __construct() {
		parent::__construct(self::APP_NAME);
	}

	public function register() {
		$this->registerNavigationEntry();
		//$this->registerNotificationNotifier();
		//$this->registerCommentsEntity();
	}

	protected function registerNavigationEntry() {
		$server = $this->getContainer()->getServer();

		$server->getNavigationManager()->add(function() use ($server) {
			$urlGenerator = $server->getURLGenerator();
			$l = $server->getL10NFactory()->get(self::APP_NAME);
			return [
				'id' => self::APP_NAME,
				'order' => 10,
				'href' => $urlGenerator->linkToRoute(self::APP_NAME . '.page.index'),
				'icon' => $urlGenerator->imagePath(self::APP_NAME, 'app.svg'),
				'name' => $l->t('Blog'),
			];
		});
	}

//	protected function registerCommentsEntity() {
//		$this->getContainer()->getServer()->getEventDispatcher()->addListener(CommentsEntityEvent::EVENT_ENTITY, function(CommentsEntityEvent $event) {
//			$event->addEntityCollection(self::APP_NAME, function($name) {
//				/** @var Manager $manager */
//				$manager = $this->getContainer()->query(Manager::class);
//				try {
//					$announcement = $manager->getAnnouncement((int) $name);
//				} catch (\InvalidArgumentException $e) {
//					return false;
//				}
//				return $announcement['comments'] !== false;
//			});
//		});
//	}
//
//	protected function registerNotificationNotifier() {
//		$this->getContainer()->getServer()->getNotificationManager()->registerNotifier(function() {
//			return $this->getContainer()->query(Notifier::class);
//		}, function() {
//			$l = $this->getContainer()->getServer()->getL10NFactory()->get(self::APP_NAME);
//			return [
//				'id' => self::APP_NAME,
//				'name' => $l->t('Blog'),
//			];
//		});
//	}
}
