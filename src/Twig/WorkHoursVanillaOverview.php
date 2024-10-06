<?php

namespace App\Twig;

use App\Form\WorkHoursVanillaSearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class WorkHoursVanillaOverview extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveAction]
    public function save()
    {
        $this->submitForm();

        dd($this->getForm()->getData());
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(WorkHoursVanillaSearchForm::class);
    }
}
