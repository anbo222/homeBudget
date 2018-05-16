<?php
/**
 * User entity.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class User.
 *
 * @ORM\Table(
 *     name="user"
 * )
 * @ORM\Entity(
 *     repositoryClass="AppBundle\Repository\CategoriesRepository"
 * )
 * @UniqueEntity(
 *     fields={"email"}
 * )
 */
class User
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
     * Name.
     *
     * @var string $name
     *
     * @ORM\Column(
     *     name="name",
     *     type="string",
     *     length=32,
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="32",
     * )
     */
    protected $name;

    /**
     * Email.
     *
     * @var string $email
     *
     * @ORM\Column(
     *     name="email",
     *     type="string",
     *     length=128,
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="5",
     *     max="128",
     * )
     */
    protected $email;

    /**
     * Password.
     *
     * @var string $password
     *
     * @ORM\Column(
     *     name="password",
     *     type="string",
     *     length=128,
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="6",
     *     max="128",
     * )
     */
    protected $password;

    /**
     * Login.
     *
     * @var string $login
     *
     * @ORM\Column(
     *     name="login",
     *     type="string",
     *     length=32,
     *     nullable=false,
     * )
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="32",
     * )
     */
    protected $login;

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
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }
}
