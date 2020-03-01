<?php

namespace Localinks\DependentAutoCompleteBundle\Form\Extension;

use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DependentAutoCompleteTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return ModelAutocompleteType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array('dependencies'));

        $resolver->setDefaults([
            'template' => '@LocalinksDependentAutoComplete/Form/dependent_auto_complete_type.html.twig',
            'dependencies' => array()
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['dependencies'])) {
            $view->vars['dependencies'] = $options['dependencies'];
        }
    }

}
