<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class TestController extends AbstractController
{
    
    /**
     * @Route("/add", name="add")
     * @Route("/add", name="add", methods={"POST", "OPTIONS"})
     */
    public function post(Request $request)
    {
        $data = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();

        $sql = "INSERT INTO test.group (name) VALUES ('" . $data->name . "');";

        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();

        return new JsonResponse("ok");
    }

   /**
    * @Route("/get_data", name="get_data")
    */
    public function getData()
    {
        $output = [];
        $entityManager = $this->getDoctrine()->getManager();

        $sql = "SELECT name FROM test.group";

        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        foreach($results as $task)
        {
            array_push($output, $task['name']);
        }
        
        return new JsonResponse($output);
        
    }

}
