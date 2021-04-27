import template from './delivery-post-code-rule.html.twig';

const { Component } = Shopware;
const { mapPropertyErrors } = Component.getComponentHelper();

Component.extend('delivery-post-code-rule', 'sw-condition-base', {
    template,

    computed: {
        zipCodeFrom: {
            get() {
                this.ensureValueExist();
                return this.condition.value.zipCodeFrom;
            },
            set(zipCodeFrom) {
                this.ensureValueExist();
                console.log("testFrom: " + zipCodeFrom);
                this.condition.value = { ...this.condition.value, zipCodeFrom };
            }
        },
        zipCodeTo: {
            get() {
                this.ensureValueExist();
                return this.condition.value.zipCodeTo;
            },
            set(zipCodeTo) {
                this.ensureValueExist();
                console.log("testTo: " + zipCodeTo);
                this.condition.value = { ...this.condition.value, zipCodeTo };
            }
        },

        ...mapPropertyErrors('condition', ['value.zipCodeFrom', 'value.zipCodeTo']),


        currentError() {
            return this.conditionTypeError || this.conditionValueZipCodeFromError || this.conditionValueZipCodeToError;
            }
        },
});
