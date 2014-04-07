<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordonneeGPS
 *
 * @ORM\Table(name="CoordonneeGPS")
 * @ORM\Entity(repositoryClass="Entity\CoordonneeGPS")En
 */
class CoordonneeGPS
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=32, precision=0, scale=0, nullable=false, unique=false)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="lattitude", type="string", length=32, precision=0, scale=0, nullable=false, unique=false)
     */
    private $lattitude;


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
     * Set longitude
     *
     * @param string $longitude
     *
     * @return CoordonneeGPS
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set lattitude
     *
     * @param string $lattitude
     *
     * @return CoordonneeGPS
     */
    public function setLattitude($lattitude)
    {
        $this->lattitude = $lattitude;

        return $this;
    }

    /**
     * Get lattitude
     *
     * @return string 
     */
    public function getLattitude()
    {
        return $this->lattitude;
    }
    
}