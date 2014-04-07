<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Garde
 *
 * @ORM\Table(name="Garde")
 * @ORM\Entity
 */
class Garde
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", length=32, precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $date;

    /**
     * @var \Entity\Pharmacie
     *
     * @ORM\ManyToOne(targetEntity="Entity\Pharmacie", inversedBy="gardes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pharmacie_id", referencedColumnName="id")
     * })
     */
    private $pharmacie;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Garde
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set pharmacie
     *
     * @param \Entity\Pharmacie $pharmacie
     *
     * @return Garde
     */
    public function setPharmacie(\Entity\Pharmacie $pharmacie = null)
    {
        $this->pharmacie = $pharmacie;

        return $this;
    }

    /**
     * Get pharmacie
     *
     * @return \Entity\Pharmacie 
     */
    public function getPharmacie()
    {
        return $this->pharmacie;
    }
}