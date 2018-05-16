<?php
/**
 * Operation type.
 */
namespace AppBundle\Form;

use AppBundle\Entity\Operation;
use AppBundle\Entity\Category;
use AppBundle\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OperationType.
 */
class OperationType extends AbstractType
{
    /**
     * Category repository.
     *
     * @var CategoriesRepository|null Category repository
     */
    protected $categoriesRepository = null;

    /**
     * OperationType constructor.
     *
     * @param CategoriesRepository $categoriesRepository Category repository
     */
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder Form builder
     * @param array                                        $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'amount',
            IntegerType::class,
            [
                'label' => 'label.amount',
                'required' => true,
            ]
        );
        $builder->add(
            'categories',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'label' => 'label.category',
                'required' => false,
                'expanded' => true,
                'multiple' => false,
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver Resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Operation::class,
            ]
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return null|string Result
     */
    public function getBlockPrefix()
    {
        return 'operation';
    }
}
