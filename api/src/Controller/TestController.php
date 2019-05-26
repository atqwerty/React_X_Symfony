<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class TestController extends AbstractController
{
    
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        // $group = new Group();
        // $group->setName("Test2");

        $sql = "INSERT INTO test.group (name) VALUES ('test');";

        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        // $entityManager->persist($group);
        // $entityManager->flush();

        return new JsonResponse('Done');
    }

}
