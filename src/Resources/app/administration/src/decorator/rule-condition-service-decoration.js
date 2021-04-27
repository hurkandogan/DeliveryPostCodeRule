import { Application } from 'src/core/shopware';
import '../core/component/delivery-post-code-rule';

Application.addServiceProviderDecorator('ruleConditionDataProviderService', (ruleConditionService) => {
    ruleConditionService.addCondition('delivery_postcode_check', {
        component: 'delivery-post-code-rule',
        label: 'Delivery Post Code Rule',
        scopes: ['global']
    });

    return ruleConditionService;
});
