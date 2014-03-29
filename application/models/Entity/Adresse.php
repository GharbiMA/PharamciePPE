<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table(name="Adresse")
 * @ORM\Entity
 */
class Adresse
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
     * @var integer
     *
     * @ORM\Column(name="numero", type="smallint", precision=0, scale=0, nullable=false, unique=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="rue", type="string", length=32, precision=0, scale=0, nullable=false, unique=false)
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="cite", type="string", length=32, precision=0, scale=0, nullable=false, unique=false)
     */
    private $cite;

    /**
     * @var \Entity\Localite
     *
     * @ORM\ManyToOne(targetEntity="Entity\Localite", inversedBy="pharmacies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="localite_id", referencedColumnName="id")
     * })
     */
    private $localite;

    /**
     * @var \Entity\Pharmacie
     *
     * @ORM\OneToOne(targetEntity="Entity\Pharmacie", inversedBy="adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pharmacie_id", referencedColumnName="id", unique=true)
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Adresse
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set rue
     *
     * @param string $rue
     *
     * @return Adresse
     */
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue
     *
     * @return string 
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set cite
     *
     * @param string $cite
     *
     * @return Adresse
     */
    public function setCite($cite)
    {
        $this->cite = $cite;

        return $this;
    }

    /**
     * Get cite
     *
     * @return string 
     */
    public function getCite()
    {
        return $this->cite;
    }

    /**
     * Set localite
     *
     * @param \Entity\Localite $localite
     *
     * @return Adresse
     */
    public function setLocalite(\Entity\Localite $localite = null)
    {
        $this->localite = $localite;

        return $this;
    }

    /**
     * Get localite
     *
     * @return \Entity\Localite 
     */
    public function getLocalite()
    {
        return $this->localite;
    }

    /**
     * Set pharmacie
     *
     * @param \Entity\Pharmacie $pharmacie
     *
     * @return Adresse
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