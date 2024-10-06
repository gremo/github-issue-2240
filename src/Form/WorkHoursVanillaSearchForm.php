<?php

namespace App\Form;

use App\Enum\Employee;
use App\Enum\Office;
use App\Model\WorkHoursSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkHoursVanillaSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('office', EnumType::class, [
                'class' => Office::class,
                'choice_label' => fn (Office $office): string => $office->getReadable(),
                'placeholder' => 'Any office',
                'required' => false,
            ])
        ;

        $formModifier = function (FormInterface $form, ?Office $office): void {
            $form->add('employee', EnumType::class, [
                'class' => Employee::class,
                'placeholder' => 'Any employee',
                'choices' => $office?->getEmployeeChoices(),
                'choice_label' => fn (Employee $employee): string => $employee->getReadable(),
                'required' => false,
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier): void {
                $formModifier($event->getForm(), $event->getData()?->office);
            }
        );

        $builder->get('office')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier): void {
                $formModifier($event->getForm()->getParent(), $event->getForm()->getData());
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => WorkHoursSearch::class]);
    }
}
