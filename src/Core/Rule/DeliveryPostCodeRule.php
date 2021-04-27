<?php declare(strict_types=1);

namespace Swag\CustomRule\Core\Rule;

use Shopware\Core\Checkout\CheckoutRuleScope;
use Shopware\Core\Framework\Rule\Rule;
use Shopware\Core\Framework\Rule\RuleScope;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraint as DateTimeConstraint;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class DeliveryPostCodeRule extends Rule
{
    protected String $zipCodeFrom;
    protected String $zipCodeTo;

    public function __construct(String $zipCodeFrom = "", String $zipCodeTo = "")
    {
        parent::__construct();
        $this->zipCodeFrom = $zipCodeFrom;
        $this->zipCodeTo = $zipCodeTo;
    }

    public function match(RuleScope $scope): bool
    {
        if (!$scope instanceof CheckoutRuleScope) {
            return false;
        }

        if (!$location = $scope->getSalesChannelContext()->getShippingLocation()->getAddress()) {
            return false;
        }

        $zipCode = intVal($location->getZipCode());

        if($this->zipCodeFrom && $this->zipCodeTo && $zipCode){
            $zipCodeFromAsInt = intval($this->zipCodeFrom);
            $zipCodeToNumberAsInt = intval($this->zipCodeTo);
        } else {
            return false;
        }

        if($zipCode >= $zipCodeFromAsInt && $zipCode <= $zipCodeToNumberAsInt){
            return true;
        } else {
            return false;
        }
    }

    public function getConstraints(): array
    {
        return [
            'zipCodeFrom' => [new NotBlank(), new Type('string')],
            'zipCodeTo' => [new NotBlank(), new Type('string')],
            'isLunarEclipse' => [ new Type('bool') ]
        ];
    }

    public function getName(): string
    {
        return 'delivery_postcode_check';
    }
}
