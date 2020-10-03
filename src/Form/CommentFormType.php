<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CommentFormType extends AbstractType
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', null, [
                'label' => 'label.name',
            ])
            ->add('text', null, [
                'label' => 'label.text',
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
            ])
            ->add('photo', FileType::class, [
                'label' => 'label.image',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'lang' => $this->requestStack->getCurrentRequest()->getLocale(),
                ],
                'constraints' => [
                  new Image(['maxSize' => '1024k'])
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'button.submit',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
