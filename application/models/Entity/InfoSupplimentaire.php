<?php



namespace Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class InfoSupplimentaire   {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id ;
    /**
     *
     * @ORM\Column(type="string", length=40, nullable=true) 
     */        
    private $specialite;    
    /**
     *
     * @ORM\Column(type="text", nullable=true) 
     */    
    private $information;
    
    /**
     *
     * @ORM\OneToOne(targetEntity="Pharmacie",inversedBy="infosuppliementaire")
     */
    private $owner;
    
    
    function __construct() {
                 
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
     * Set specialite
     *
     * @param string $specialite
     * @return InfoSupplimentaire
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
        return $this;
    }

    /**
     * Get specialite
     *
     * @return string 
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set information
     *
     * @param text $information
     * @return InfoSupplimentaire
     */
    public function setInformation($information)
    {
        $this->information = $information;
        return $this;
    }

    /**
     * Get information
     *
     * @return text 
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Set owner
     *
     * @param Entity\Pharmacie $owner
     * @return InfoSupplimentaire
     */
    public function setOwner(\Entity\Pharmacie $owner = null)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get owner
     *
     * @return Entity\Pharmacie 
     */
    public function getOwner()
    {
        return $this->owner;
    }
}