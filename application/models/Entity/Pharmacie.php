<?php


namespace Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Entity\Pharmacie
 *
 * 
 * @ORM\Entity
 */
class Pharmacie
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
     * @var string $tel
     *
     * @ORM\Column(name="tel", type="string", length=32, precision=0, scale=0, nullable=false, unique=false)
     */
    private $tel;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=10, precision=0, scale=0, nullable=false, unique=false)
     */
    private $type;

    /**
     * @var Entity\CoordonneeGPS
     *
     * @ORM\OneToOne(targetEntity="Entity\CoordonneeGPS")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="coordonneegps_id", referencedColumnName="id", unique=true)
     * })
     */
    private $coordonneegps;

    /**
     * @var Entity\InfoSupplimentaire
     *
     * @ORM\OneToOne(targetEntity="Entity\InfoSupplimentaire", mappedBy="owner")
     */
    private $infosuppliementaire;

    /**
     * @var Entity\Adresse
     *  
     * @ORM\OneToOne(targetEntity="Entity\Adresse", inversedBy="pharmacie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adresse_id", referencedColumnName="id", unique=true)
     * })
     * 
     */
    private $adresse;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Entity\Garde", mappedBy="pharmacie")
     */
    private $gardes;

    public function __construct()
    {
        $this->gardes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Pharmacie
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
     * Set tel
     *
     * @param string $tel
     * @return Pharmacie
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Pharmacie
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set coordonneegps
     *
     * @param Entity\CoordonneeGPS $coordonneegps
     * @return Pharmacie
     */
    public function setCoordonneegps(\Entity\CoordonneeGPS $coordonneegps = null)
    {
        $this->coordonneegps = $coordonneegps;
        return $this;
    }

    /**
     * Get coordonneegps
     *
     * @return Entity\CoordonneeGPS 
     */
    public function getCoordonneegps()
    {
        return $this->coordonneegps;
    }

    /**
     * Set infosuppliementaire
     *
     * @param Entity\InfoSupplimentaire $infosuppliementaire
     * @return Pharmacie
     */
    public function setInfosuppliementaire(\Entity\InfoSupplimentaire $infosuppliementaire = null)
    {
        $this->infosuppliementaire = $infosuppliementaire;
        return $this;
    }

    /**
     * Get infosuppliementaire
     *
     * @return Entity\InfoSupplimentaire 
     */
    public function getInfosuppliementaire()
    {
        return $this->infosuppliementaire;
    }

    /**
     * Set adresse
     *
     * @param Entity\Adresse $adresse
     * @return Pharmacie
     */
    public function setAdresse(\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * Get adresse
     *
     * @return Entity\Adresse 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Add gardes
     *
     * @param Entity\Garde $gardes
     * @return Pharmacie
     */
    public function addGarde(\Entity\Garde $gardes)
    {
        $this->gardes[] = $gardes;
        return $this;
    }

    /**
     * Get gardes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGardes()
    {
        return $this->gardes;
    }
}