<?php declare(strict_types=1);

namespace Swag\CustomRule\Core\Rule;

use Shopware\Core\Framework\Rule\Rule;
use Shopware\Core\Framework\Rule\RuleScope;
use Shopware\Core\Framework\Validation\Constraint\ArrayOfType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraint as DateTimeConstraint;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class LunarEclipseRule extends Rule
{
    /**
     * @var bool
     */
    protected $isLunarEclipse;

    public function __construct()
    {
        parent::__construct();

        // Will be overwritten at runtime. Reflects the expected value.
        $this->isLunarEclipse = false;
    }

    public function getName(): string
    {
        return 'delivery_postcode_check';
    }

    public function match(RuleScope $scope): bool
    {
        // Not implemented in this example
        $isCurrentlyLunarEclipse = true;

        // Checks if the shop administrator set the rule to "Lunar eclipse => Yes"
        if ($this->isLunarEclipse) {
            // Shop administrator wants the rule to match if there's currently a lunar eclipse.
            return $isCurrentlyLunarEclipse;
        }

        // Shop administrator wants the rule to match if there's currently NOT a lunar eclipse.
        return !$isCurrentlyLunarEclipse;
    }

    public function getConstraints(): array
    {
        return [
            'zipCodeFrom' => [new NotBlank(), new Type('string')],
            'zipCodeTo' => [new NotBlank(), new Type('string')],
            'isLunarEclipse' => [ new Type('bool') ]
        ];
    }
}
