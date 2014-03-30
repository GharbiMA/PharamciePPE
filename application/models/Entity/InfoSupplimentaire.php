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
}
