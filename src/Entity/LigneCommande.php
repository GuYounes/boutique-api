<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Groups;

/**
 * LigneCommande
 *
 * @ORM\Table(name="ligne_commande", indexes={@ORM\Index(name="id_article", columns={"id_article"}), @ORM\Index(name="id_commande", columns={"id_commande"})})
 * @ORM\Entity
 */
class LigneCommande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_ligne", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @Groups({"toSerialize"})
     */
    private $idLigne;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     *
     * @JMS\Type("integer")
     *
     * @Groups({"toSerialize"})
     */
    private $quantite;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_article", referencedColumnName="id")
     * })
     *
     * @JMS\Type("App\Entity\Article")
     *
     * @Groups({"toSerialize"})
     */
    private $article;

    /**
     * @var Commande
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_commande", referencedColumnName="id")
     * })
     *
     * @JMS\Type("App\Entity\Commande")
     *
     * @Groups({"toSerialize"})
     */
    private $commande;

    /**
     * @return int
     */
    public function getIdLigne()
    {
        return $this->idLigne;
    }

    /**
     * @param int $idLigne
     */
    public function setIdLigne($idLigne)
    {
        $this->idLigne = $idLigne;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return Commande
     */
    public function getCommande()
    {
        return $this->idCommande;
    }

    /**
     * @param $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }

    public function toArray()
    {
        return array("id" => $this->idLigne,
            "quantite" => $this->quantite,
            "article" => $this->article->toArray(),
            "commande" => $this->commande->toArray());
    }

}
