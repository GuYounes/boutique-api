<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion", indexes={@ORM\Index(name="IDX_C11D7DD1DCA7A716", columns={"id_article"})})
 * @ORM\Entity
 */
class Promotion
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="datetime", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @Groups({"toSerialize"})
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=false)
     *
     * @Groups({"toSerialize"})
     */
    private $dateFin;

    /**
     * @var int
     *
     * @ORM\Column(name="pourcentage", type="integer", nullable=false)
     *
     * @Groups({"toSerialize"})
     */
    private $pourcentage;

    /**
     * @var Article
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_article", referencedColumnName="id")
     * })
     *
     * @Groups({"toSerialize"})
     */
    private $article;

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return int
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }

    /**
     * @param int $pourcentage
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->idArticle;
    }

    /**
     * @param $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    public function toArray()
    {
        return array("dateDebut" => $this->dateDebut,
            "dateFin" => $this->dateFin,
            "pourcentage" => $this->pourcentage,
            "article" => $this->article->toArray());
    }
}
