<?php

namespace AppBundle\Provider;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DataProvider
{
    protected $manager;
    protected $formFactory;

    public function __construct(EntityManager $manager, FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
    }

    public function createOrUpdate(Request $request, $entity, $type, $options = []) {
        $options = array_merge([
            'exception' => new BadRequestHttpException()
        ], $options);

        $form = $this->formFactory->create($type, $entity);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isValid()) {
            $this->manager->persist($entity);
            $this->manager->flush();

            return $entity;
        }

        throw $options['exception'];
    }
}
