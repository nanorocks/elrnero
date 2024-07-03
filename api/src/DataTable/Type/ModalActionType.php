<?php

namespace App\DataTable\Type;

use Kreyu\Bundle\DataTableBundle\Action\Type\AbstractActionType;
use Kreyu\Bundle\DataTableBundle\Action\Type\ButtonActionType;

class ModalActionType extends AbstractActionType
{
    public function getParent(): ?string
    {
        return ButtonActionType::class;
    }
}