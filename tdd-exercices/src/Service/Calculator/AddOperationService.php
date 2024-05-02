<?php

namespace App\Service\Calculator;

class AddOperationService extends AbstractOperationService
{
    public function __construct($leftOperand, $rightOperand)
    {
        parent::__construct($leftOperand, $rightOperand);
    }
    
    public function getValue(): float
    {
        if(is_numeric($this->leftOperand) && is_numeric($this->rightOperand)){
            return $this->leftOperand + $this->rightOperand;
        }

        throw new \Exception("Operands must be numeric");
    }
}
