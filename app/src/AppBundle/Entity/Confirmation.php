<?php
/**
 * Confirmation entity.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Confirmation.
 *
 * @ORM\Table(
 *     name="confirmation"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\CategoriesRepository"
 * )
 * @UniqueEntity(
 *     fields={"confirmation"}
 * )
 */
class Confirmation
{
    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     */
    const NUM_ITEMS = 10;

    /**
     * Primary key.
     *
     * @var int $id
     *
     * @ORM\Id
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     nullable=false,
     *     options={"unsigned"=true},
     * )
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Confirmation.
     *
     * @var string $confirmation
     *
     * @ORM\Column(
     *     name="confirmation",
     *     type="string",
     *     length=45,
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    protected $confirmation;

    /**
     * Flag.
     *
     * @var string $flag
     *
     * @ORM\Column(
     *     name="flag",
     *     type="string",
     *     length=1,
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="1",
     *     max="1",
     * )
     */
    protected $flag;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set confirmation
     *
     * @param string $confirmation
     *
     * @return Confirmation
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * Get confirmation
     *
     * @return string
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * Set flag
     *
     * @param string $flag
     *
     * @return Confirmation
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }
}
