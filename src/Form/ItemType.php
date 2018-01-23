<?php
/**
 * Created by PhpStorm.
 * User: Kamil Roczniok
 * Date: 2018-01-21
 * Time: 14:48
 */

namespace App\Form;


use App\Entity\ItemCategory;
use App\Entity\ItemGenre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // prepare standard fields
        $builder
            ->add('name', TextType::class, array(
                'attr' => array('maxlength' => 100) // @todo use constants
            ))
            ->add('description', TextareaType::class, array(
                'required' => false,
                'attr' => array('maxlength' => 1000) // @todo use constants
            ))
            ->add('category', EntityType::class, [
                'class' => ItemCategory::class,
                'placeholder' => 'Choose an option',
                'choice_label' => function ($category) {
                    /** @var ItemCategory $category */
                    return $category->getName();
                }
            ])
            ->add('save', SubmitType::class, array('label' => 'Save item'));

        // if category is selected then add genres selectbox
        $formModifier = function (FormInterface $form, ItemCategory $itemCategory = null) {
            $genres = null === $itemCategory ? array() : $itemCategory->getGenres();

            $form->add('genre', ChoiceType::class, [
                'choices' => $genres,
                'placeholder' => 'Choose an option',
                'choice_label' => function ($genre) {
                    /** @var ItemGenre $genre */
                    return $genre->getName();
                }
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getCategory());
            }
        );

        $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $category = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $category);
            }
        );
    }
}