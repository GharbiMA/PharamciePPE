<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity\Localite
 *
 * @ORM\Table(name="Localite")
 * @ORM\Entity
 */
class Localite
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
     * @var smallint $CodePostal
     *
     * @ORM\Column(name="CodePostal", type="smallint", precision=0, scale=0, nullable=false, unique=false)
     */
    private $CodePostal;

    /**
     * @var Entity\Gouvernorat
     *
     * @ORM\ManyToOne(targetEntity="Entity\Gouvernorat", inversedBy="localites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gouvernerat_id", referencedColumnName="id")
     * })
     */
    private $gouvernerat;

    /**
     * @var Entity\CoordonneeGPS
     *
     * @ORM\OneToOne(targetEntity="Entity\CoordonneeGPS")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="coordonnegps_id", referencedColumnName="id", unique=true)
     * })
     */
    private $coordonnegps;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Entity\Adresse", mappedBy="localite")
     */
    private $pharmacies;

    public function __construct()
    {
        $this->pharmacies = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Localite
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
     * Set CodePostal
     *
     * @param smallint $codePostal
     * @return Localite
     */
    public function setCodePostal($codePostal)
    {
        $this->CodePostal = $codePostal;
        return $this;
    }

    /**
     * Get CodePostal
     *
     * @return smallint 
     */
    public function getCodePostal()
    {
        return $this->CodePostal;
    }

    /**
     * Set gouvernerat
     *
     * @param Entity\Gouvernorat $gouvernerat
     * @return Localite
     */
    public function setGouvernerat(\Entity\Gouvernorat $gouvernerat = null)
    {
        $this->gouvernerat = $gouvernerat;
        return $this;
    }

    /**
     * Get gouvernerat
     *
     * @return Entity\Gouvernorat 
     */
    public function getGouvernerat()
    {
        return $this->gouvernerat;
    }

    /**
     * Set coordonnegps
     *
     * @param Entity\CoordonneeGPS $coordonnegps
     * @return Localite
     */
    public function setCoordonnegps(\Entity\CoordonneeGPS $coordonnegps = null)
    {
        $this->coordonnegps = $coordonnegps;
        return $this;
    }

    /**
     * Get coordonnegps
     *
     * @return Entity\CoordonneeGPS 
     */
    public function getCoordonnegps()
    {
        return $this->coordonnegps;
    }

    /**
     * Add pharmacies
     *
     * @param Entity\Adresse $pharmacies
     * @return Localite
     */
    public function addAdresse(\Entity\Adresse $pharmacies)
    {
        $this->pharmacies[] = $pharmacies;
        return $this;
    }

    /**
     * Get pharmacies
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPharmacies()
    {
        return $this->pharmacies;
    }
}