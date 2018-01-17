<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups({"toSerialize"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     *
     * @Groups({"toSerialize"})
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="visuel", type="string", length=255, nullable=false)
     *
     * @Groups({"toSerialize"})
     */
    private $visuel;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getVisuel()
    {
        return $this->visuel;
    }

    /**
     * @param string $visuel
     */
    public function setVisuel($visuel)
    {
        $this->visuel = $visuel;
    }

    public function toArray()
    {
        return array("id" => $this->id,
            "nom" => $this->nom,
            "visuel" => $this->visuel);
    }


}
