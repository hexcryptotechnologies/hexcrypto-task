  require(
    [
            'Magento_Ui/js/lib/validation/validator',
            'jquery',
            'uiRegistry',
    ],
    function (validator, $, uiRegistry) {
            validator.addRule(
                'date-range-validation',
                function (value, param) {
                    var index = (param =='end_time') ? 'start_time' : 'end_time';
                    var field = uiRegistry.get('index ='+index);
                    if (param =='end_time' && field.value()) {
                        var startDate = new Date(field.value());
                        var endDate = new Date(value);
                        if (endDate < startDate) {
                           return false;
                        } else {
                           return true;
                        }
                    } else if (field.value() && param == 'start_time') {
                        var startDate = new Date(value);
                        var endDate = new Date(field.value());
                        if (endDate < startDate) {
                           return false;
                        } else {
                           return true;
                        }
                    } else {
                           return true;
                    }
                }
                ,
                $.mage.__('End date must follow start date')
            );
    }
);