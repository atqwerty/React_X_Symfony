<?php
    // src/Entity/Group.php
    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;

   /**
    * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
    */
    class Group
    {
       /**
        * @ORM\Id
        * @ORM\GeneratedValue
        * @ORM\Column(type="integer")
        */
        private $id;

       /**
        * @ORM\Column(type="string", length=255)
        */
        private $name;

        public function getId()
        {
            return $this->id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($value)
        {
            $this->name = $value;
        }
    }
?>