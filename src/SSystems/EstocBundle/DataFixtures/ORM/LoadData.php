<?php

namespace SSystems\EstocBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SSystems\EstocBundle\Entity\CollaboratorType;

class LoadData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $collaboratorType = new CollaboratorType();
        $collaboratorType->setName('Fotógrafo');
        $manager->persist($collaboratorType);

        $collaboratorType = new CollaboratorType();
        $collaboratorType->setName('Ilustrador');
        $manager->persist($collaboratorType);

        $collaboratorType = new CollaboratorType();
        $collaboratorType->setName('Diseñador');
        $manager->persist($collaboratorType);

        $manager->flush();
    }
}