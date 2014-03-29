<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity\InfoSupplimentaire
 *
 * @ORM\Table(name="InfoSupplimentaire")
 * @ORM\Entity
 */
class InfoSupplimentaire
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
     * @var string $specialite
     *
     * @ORM\Column(name="specialite", type="string", length=40, precision=0, scale=0, nullable=true, unique=false)
     */
    private $specialite;

    /**
     * @var text $information
     *
     * @ORM\Column(name="information", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $information;

    /**
     * @var Entity\Pharmacie
     *
     * @ORM\OneToOne(targetEntity="Entity\Pharmacie", inversedBy="infosuppliementaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="id", unique=true)
     * })
     */
    private $owner;


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