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
     * @Route("/add", name="add", methods={"POST", "OPTIONS"})
     */
    public function post(Request $request)
    {
        $data = json_decode($request->getContent());

        $sql = "INSERT INTO test.group (name) VALUES ('" . $data->name . "');";
        $sql2 = "SELECT LAST_INSERT_ID();"; // Get last added item id in order to render it in index.js

        // Execute first query
        $this->queryPrep($sql);
        
        // Execute second query anf obtain the result
        $stmt = $this->queryPrep($sql2);
        $result = $stmt->fetchAll();

        return new JsonResponse($result);
    }

   /**
    * @Route("/get_data", name="get_data", methods={"GET"})
    */
    public function getData()
    {
        $output = [];

        $sql = "SELECT * FROM test.group";

        // Put queryPrep() output in $stmt in order to pass it to index.js
        $stmt = $this->queryPrep($sql);
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

        $sql = "DELETE FROM test.group WHERE id = '". $key->id ."';";

        // No need to obtain the output
        $this->queryPrep();

        return new JsonResponse($key->id);
    }

    // Sums up the basic operations in order to execute query
    function queryPrep($sql){
        $entityManager = $this->getDoctrine()->getManager();

        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt;
    }
}
