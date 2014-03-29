<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity\Gouvernorat
 *
 * @ORM\Table(name="Gouvernorat")
 * @ORM\Entity
 */
class Gouvernorat
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=32, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nom;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Entity\Localite", mappedBy="gouvernerat")
     */
    private $localites;

    public function __construct()
    {
        $this->localites = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Gouvernorat
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add localites
     *
     * @param Entity\Localite $localites
     * @return Gouvernorat
     */
    public function addLocalite(\Entity\Localite $localites)
    {
        $this->localites[] = $localites;
        return $this;
    }

    /**
     * Get localites
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLocalites()
    {
        return $this->localites;
    }
}