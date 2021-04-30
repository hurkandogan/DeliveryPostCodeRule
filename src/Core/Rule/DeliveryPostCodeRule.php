<?php declare(strict_types=1);

namespace Swag\CustomRule\Core\Rule;

use Shopware\Core\Checkout\CheckoutRuleScope;
use Shopware\Core\Framework\Rule\Rule;
use Shopware\Core\Framework\Rule\RuleScope;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class DeliveryPostCodeRule extends Rule {
    protected $zipCodeFrom;
    protected $zipCodeTo;

    public function __construct($zipCodeFrom = 0, $zipCodeTo = 0) {
        parent::__construct();
        $this->zipCodeFrom = $zipCodeFrom;
        $this->zipCodeTo = $zipCodeTo;
    }

    public function match(RuleScope $scope): bool {

        if (!$scope instanceof CheckoutRuleScope) {
            return false;
        }

        if (!$location = $scope->getSalesChannelContext()->getShippingLocation()->getAddress()) {
            return false;
        }
        // Validation
        if($this->zipCodeFrom < $this->zipCodeTo){
            return false;
        }

        $zipCode = intVal($location->getZipCode());

        $zipCodeFromInt = intVal($this->zipCodeFrom);
        $zipCodeToInt = intVal($this->zipCodeTo);

        if(!empty($zipCode) && ($zipCodeFromInt > 0 && $zipCodeToInt > 0)){
            if($zipCode >= $zipCodeFromInt && $zipCode <= $zipCodeToInt){
                return true;
            }
        }
        return false;
   }

    public function getConstraints(): array {
        return [
            'zipCodeFrom' => [new NotBlank(), new Type('int')],
            'zipCodeTo' => [new NotBlank(), new Type('int')],
        ];
    }

    public function getName(): string {
        return 'delivery_postcode_check';
    }
}
