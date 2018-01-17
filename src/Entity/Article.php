<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"})})
 * @ORM\Entity
 */
class Article
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
     * @ORM\Column(name="reference", type="string", length=255, nullable=false)
     *
     * @Groups({"toSerialize"})
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     *
     * @Groups({"toSerialize"})
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="tarif", type="float", precision=10, scale=2, nullable=false)
     *
     * @Groups({"toSerialize"})
     */
    private $tarif;

    /**
     * @var string
     *
     * @ORM\Column(name="visuel", type="string", length=255, nullable=false)
     *
     * @Groups({"toSerialize"})
     */
    private $visuel;

    /**
     * @var Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id")
     * })
     *
     * @Groups({"toSerialize"})
     */
    private $categorie;

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
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
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
     * @return float
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * @param float $tarif
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;
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

    /**
     * @return Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param Categorie $categorie
     */
    public function setCategorie(Categorie $categorie)
    {
        $this->categorie = $categorie;
    }

    public function toArray()
    {
        return array("id" => $this->id,
            "reference" => $this->reference,
            "nom" => $this->nom,
            "tarif" => $this->tarif,
            "visuel" => $this->visuel,
            "categorie" => $this->categorie->toArray());
    }

}
