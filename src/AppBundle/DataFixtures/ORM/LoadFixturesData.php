<?php
namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadUserData implements FixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $files = [];
        $files[] = __DIR__ . '/Promotion/promotion.yml';
        $files[] = __DIR__ . '/Promotion/year.yml';
        $files[] = __DIR__ . '/Promotion/period.yml';
        $files[] = __DIR__ . '/user.yml';
        $files[] = __DIR__ . '/student.yml';
        $files[] = __DIR__ . '/Course/course.yml';
        $files[] = __DIR__ . '/Course/note.yml';
        $files[] = __DIR__ . '/Course/result.yml';
        $files[] = __DIR__ . '/beacon.yml';
        $files[] = __DIR__ . '/Presence/historic.yml';

        Fixtures::load($files, $manager, [
            'locale'    => 'fr_FR',
            'persist_once' => false,
        ]);

        $manager->flush();
    }

}
