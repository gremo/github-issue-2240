<?php

namespace App\Form;

use App\Enum\Employee;
use App\Enum\Office;
use App\Model\WorkHoursSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class WorkHoursSearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('office', EnumType::class, [
                'class' => Office::class,
                'choice_label' => fn (Office $office): string => $office->getReadable(),
                'placeholder' => 'Any office',
                'required' => false,
            ])
            ->addDependent('employee', 'office', function (DependentField $field, ?Office $office) {
                $field->add(EnumType::class, [
                    'class' => Employee::class,
                    'placeholder' => 'Any employee',
                    'choices' => $office?->getEmployeeChoices(),
                    'choice_label' => fn (Employee $employee): string => $employee->getReadable(),
                    'required' => false,
                ]);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => WorkHoursSearch::class]);
    }
}
