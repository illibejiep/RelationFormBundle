<?php

namespace RelationFormBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use RelationFormBundle\Form\DataTransformer\RelationDataTransformer;
use RelationFormBundle\Model\FieldGuesser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelationType extends AbstractType {
    /** @var  EntityManager */
    protected $em;

    protected $entityClass;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new RelationDataTransformer($this->em));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $parentEntity = $form->getParent()->getData();
        $parentEntityClass = get_class($parentEntity);
        $parentMetadata = $this->em->getClassMetadata($parentEntityClass);

        $associationMapping = $parentMetadata->associationMappings[$form->getName()];
        $relationEntityClass = $associationMapping['targetEntity'];
        $relationMetadata = $this->em->getClassMetadata($relationEntityClass);
        $view->vars['entity_name'] = $relationEntityClass;

        $view->vars['fields'] = $relationMetadata->fieldNames;

        $view->vars['query_field'] = $options['search_field'];
        if (!$options['search_field'])
            $view->vars['query_field'] = FieldGuesser::guessTitleField($relationMetadata);

        if($associationMapping['type'] & ClassMetadataInfo::TO_MANY) {
            $view->vars['multiple'] = true;
            $view->vars['full_name'] .= '[' . htmlspecialchars($relationEntityClass) . '][]';
        } else {
            $view->vars['multiple'] = false;
            $view->vars['full_name'] .= '[' . htmlspecialchars($relationEntityClass) . ']';
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $class = &$this->entityClass;
        $resolver->setDefaults(array(
            'compound' => false,
            'search_field' => null,
        ));
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'relation_form';
    }

} 