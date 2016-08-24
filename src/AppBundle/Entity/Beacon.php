<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Promotion\Promotion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Beacon
 *
 * @ORM\Table(name="beacon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BeaconRepository")
 */
class Beacon
{
    public function __construct()
    {
        $this->promotions = new ArrayCollection();
    }

    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="secure_uuid", type="string", length=255, unique=true)
     */
    private $secureUuid;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Promotion\Promotion", mappedBy="beacons", cascade={"persist"})
     */
    private $promotions;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set secureUuid
     *
     * @param string $secureUuid
     *
     * @return Beacon
     */
    public function setSecureUuid($secureUuid)
    {
        $this->secureUuid = $secureUuid;

        return $this;
    }

    /**
     * Get secureUuid
     *
     * @return string
     */
    public function getSecureUuid()
    {
        return $this->secureUuid;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Beacon
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Promotion $promotion
     * @return Beacon
     */
    public function addPromotion(Promotion $promotion = null)
    {
        $this->promotions->add($promotion);
        if ($promotion->getBeacons() && !$promotion->getBeacons()->contains($this)) {
            $promotion->addBeacon($this);
        }

        return $this;
    }

    /**
     * @param Promotion $promotion
     * @return Beacon
     */
    public function removePromotion(Promotion $promotion)
    {
        $this->promotions->remove($promotion);
        $promotion->removeBeacon($this);

        return $this;
    }

    /**
     * @return ArrayCollection<Promotion>
     */
    public function getPromotions()
    {
        return $this->promotions;
    }
}

