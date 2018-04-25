<?php
/**
 * Bookmark type.
 */
namespace AppBundle\Form;

use AppBundle\Entity\Bookmark;
use AppBundle\Entity\Tag;
use AppBundle\Repository\TagsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BookmarkType.
 */
class BookmarkType extends AbstractType
{
    /**
     * Tag repository.
     *
     * @var TagsRepository|null Tag repository
     */
    protected $tagsRepository = null;

    /**
     * BookmarkType constructor.
     *
     * @param TagsRepository $tagsRepository Tag repository
     */
    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
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
            'title',
            TextType::class,
            [
                'label' => 'label.title',
                'required' => true,
                'attr' => [
                    'max_length' => 128,
                ],
            ]
        );
        $builder->add(
            'url',
            UrlType::class,
            [
                'label' => 'label.url',
                'required' => true,
                'attr' => [
                    'max_length' => 255,
                    'readonly' => (isset($options['data']) && $options['data']->getId()),
                ],
            ]
        );
        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label.tags',
                'required' => true,
                'attr' => [
                    'max_length' => 255,
                ],
            ]
        );
        $builder->get('tags')->addModelTransformer(
            new TagsDataTransformer($this->tagsRepository)
        );
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                $normData = $form->getNormData();

                if ($normData->getId()) {
                    $data['url'] = $normData->getUrl();
                    $event->setData($data);
                }
            }
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
                'data_class' => Bookmark::class,
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
        return 'bookmark';
    }
}
