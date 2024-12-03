<?php

namespace App\Form;

use App\Entity\Delegacion;
use App\Entity\Oficio;
use App\Entity\Registro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\OficioRepository;

class BusquedaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oficio', EntityType::class, [
                'class' => Oficio::class,
                'choice_label' => 'name',
                'query_builder' => function (OficioRepository $repo) {
                    // Solo incluir oficios habilitados (status = 1)
                    return $repo->createQueryBuilder('o')
                                ->where('o.status = :status')
                                ->setParameter('status', true);
                },
                'placeholder' => '-- SELECCIONAR UN OFICIO --', // Texto por defecto
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('delegacion', EntityType::class, [
                'class' => Delegacion::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false, // Menú desplegable
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Registro::class,
        ]);
    }
}
