<?php

namespace App\Form;

use App\Entity\Delegacion;
use App\Entity\Oficio;
use App\Entity\Registro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType as TextArea;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Repository\OficioRepository;

class RegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Nombre
            ->add('name', null, [
                'label' => 'Nombre',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese su nombre'],
            ])
            // Email
            ->add('email', null, [
                'label' => 'Correo Electrónico',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese su correo electrónico'],
            ])
            // Descripción
            ->add('description', TextArea::class, [
                'label' => 'Descripción',
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 250,
                    'placeholder' => 'Ingrese una descripción (máximo 250 caracteres)',
                ],
            ])
            // Fecha
            ->add('date', DateType::class, [
                'label' => 'Fecha',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'form-control date-input',
                    'placeholder' => 'DD-MM-YYYY',
                ],
            ])
            // Teléfono
            ->add('phone', null, [
                'label' => 'Teléfono',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese su teléfono'],
            ])
            // DNI
            ->add('dni', null, [
                'label' => 'DNI',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese su DNI'],
            ])
            // Dirección
            ->add('address', null, [
                'label' => 'Dirección',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese su dirección'],
            ])
            // Dirección de Trabajo
            ->add('workAddress', null, [
                'label' => 'Dirección de Trabajo',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese la dirección de trabajo'],
            ])
            // Pago
            ->add('payment', null, [
                'label' => 'Método de Pago',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese el método de pago'],
            ])
            // Tiempo
            ->add('time', null, [
                'label' => 'Horario',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese el horario'],
            ])
            // Certificación
            ->add('certification', ChoiceType::class, [
                'label' => 'Certificación',
                'choices' => [
                    'Sí' => true,
                    'No' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'form-check-input me-3'],
            ])
            // Institución
            ->add('institution', null, [
                'label' => 'Institución',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese la institución (opcional)'],
            ])
            // Recomendación
            ->add('recomendation', null, [
                'label' => 'Recomendación',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ingrese una recomendación (opcional)'],
            ])
            // Archivo de Imagen
            ->add('imageFile', FileType::class, [
                'label' => 'Imagen (opcional)',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            // Oficio (con filtro)
            ->add('oficio', EntityType::class, [
                'class' => Oficio::class,
                'query_builder' => function (OficioRepository $repo) {
                    return $repo->createQueryBuilder('o')
                        ->where('o.status = :status')
                        ->setParameter('status', true);
                },
                'choice_label' => 'name',
                'label' => 'Oficio',
                'placeholder' => '-- SELECCIONAR UN OFICIO --',
                'attr' => ['class' => 'form-select'],
            ])
            // Delegación
            ->add('delegacion', EntityType::class, [
                'class' => Delegacion::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => function () {
                    return ['class' => 'form-check-input me-3 mb-3'];
                },
                'label' => 'Delegación',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Registro::class,
        ]);
    }
}
