<?php

namespace App\Form;

use App\Entity\Quack;
use App\Entity\QuackComment;
use ContainerNxKQmTC\getQuackCommentTypeService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class QuackComment1Type extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('comment')





        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuackComment::class,
        ]);
    }

}
