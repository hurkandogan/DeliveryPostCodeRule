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

    /**
     * @var String
     */
    protected $zipCodeFrom;
    /**
     * @var String
     */
    protected $zipCodeTo;

    public function __construct(String $zipCodeFrom = null, String $zipCodeTo = null) {

        parent::__construct();
        $this->zipCodeFrom = $zipCodeFrom;
        $this->zipCodeTo = $zipCodeTo;
    }

    public function getName(): string {
        return 'delivery_postcode_check';
    }

    public function match(RuleScope $scope): bool {

        if (!$scope instanceof CheckoutRuleScope) {
            return false;
        }

        if (!$location = $scope->getSalesChannelContext()->getShippingLocation()->getAddress()) {
            return false;
        }

        $zipCode = intVal($location->getZipCode());

        if(!$this->zipCodeFrom < !$this->zipCodeTo){
            return false;
        }

        if(!$this->zipCodeFrom && !$this->zipCodeTo && !empty($zipCode)){
            return false;
        }

        $zipCodeFromInt = intVal($this->zipCodeFrom);
        $zipCodeToInt = intVal($this->zipCodeTo);

        if(($zipCodeFromInt > 0 && $zipCodeToInt > 0) &&
            ($zipCode >= $zipCodeFromInt && $zipCode <= $zipCodeToInt)){
            return true;
        }
        return false;
   }

    public function getConstraints(): array {
        return [
            'zipCodeFrom' => [new NotBlank(), new Type('String')],
            'zipCodeTo' => [new NotBlank(), new Type('String')],
        ];
    }

}
