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
        $sql2 = "SELECT LAST_INSERT_ID();";

        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        
        $stmt = $entityManager->getConnection()->prepare($sql2);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return new JsonResponse($result);
    }

   /**
    * @Route("/get_data", name="get_data", methods={"GET"})
    */
    public function getData()
    {
        $output = [];
        $entityManager = $this->getDoctrine()->getManager();

        $sql = "SELECT * FROM test.group";

        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        foreach($results as $task)
        {
            array_push($output, $task);
        }
        
        return new JsonResponse($output);
        
    }

   /**
    * @Route("/delete_task", name="delete_task")
    */
    public function deleteTask(Request $request)
    {
        $key = json_decode($request->getContent());

        $entityManager = $this->getDoctrine()->getManager();

        $sql = "DELETE FROM test.group WHERE id = '". $key->key ."';";
        // $stmt = $entityManager->getConnection()->prepare($sql);
        // $stmt->execute();

        return new JsonResponse($key->key);
    }
    
}
