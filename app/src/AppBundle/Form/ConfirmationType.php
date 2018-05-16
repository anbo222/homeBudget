<?php
/**
 * Confirmation type.
 */
namespace AppBundle\Form;

use AppBundle\Entity\Confirmation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ConfirmationType.
 */
class ConfirmationType extends AbstractType
{

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder Form builder
     * @param array                                        $options Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'confirmation',
            TextType::class,
            [
                'label' => 'label.confirmation',
                'required' => true,
                'attr' => [
                    'max_length' => 45,
                ],
            ]
        );
        $builder->add(
            'flag',
            TextType::class,
            [
                'label' => 'label.flag',
                'required' => true,
                'attr' => [
                    'max_length' => 1,
                ],
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
                'data_class' => Confirmation::class,
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
        return 'confirmation';
    }
}