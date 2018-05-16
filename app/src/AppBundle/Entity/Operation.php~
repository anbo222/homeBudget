<?php
/**
 * Operation entity.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Operation.
 *
 * @ORM\Table(
 *     name="operations"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\OperationsRepository"
 * )
 * @UniqueEntity(
 *     fields={"title"}
 * )
 */
class Operation
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
     * Amount.
     *
     * @var int $amount
     *
     * @ORM\Column(
     *     name="amount",
     *     type="integer",
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank
     */
    protected $amount;

    /**
     * Categories.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection $categories
     *
     * Many Operations have One Category.
     * @ORM\ManyToOne(
     *     targetEntity="Category",
     *     inversedBy="operations"
     * )
     * @ORM\JoinColumn(
     *     name="category_id",
     *     referencedColumnName="id"
     * )
     */
    protected $categories;

    /**
     * Created at.
     *
     * @var \DateTime $createdAt
     *
     * @ORM\Column(
     *     name="created_at",
     *     type="datetime",
     *     nullable=false,
     * )
     * @Gedmo\Timestampable(
     *     on="create",
     * )
     */
    protected $createdAt;

    /**
     * Modified at.
     *
     * @var \DateTime $modifiedAt
     *
     * @ORM\Column(
     *     name="modified_at",
     *     type="datetime",
     * )
     * @Gedmo\Timestampable(
     *     on="update",
     * )
     */
    protected $modifiedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Operation
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Operation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return Operation
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set categories
     *
     * @param \AppBundle\Entity\Category $categories
     *
     * @return Operation
     */
    public function setCategories(\AppBundle\Entity\Category $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
