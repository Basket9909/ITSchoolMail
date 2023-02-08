<?php

namespace App\Form;

use App\Entity\Mail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sender', EmailType::class,[
                'attr' => [
                    'class' => 'form'
                ],
                'label' => 'Votre adresse mail'
            ])
            ->add('recipient', EmailType::class,[
                'attr' => [
                    'class' => 'form'
                ],
                'label' => 'Adresse mail du destinataire'
            ])
            ->add('object',TextType::class,[
                'attr' => [
                    'class' => 'form'
                ],
                'label' => 'Objet du mail'
            ])
            ->add('content',TextareaType::class,[
                'attr' => [
                    'class' => 'form big_text'
                ],
                'label' => 'Votre message'
            ])
            ->add('submit',SubmitType::class,[
                'attr' => [
                    'class' => 'button form'
                ],
                'label' => 'Envoyer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mail::class,
        ]);
    }
}
