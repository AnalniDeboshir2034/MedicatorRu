document.addEventListener('DOMContentLoaded', function () {
    var phoneInputs = document.querySelectorAll('input[type="tel"]');
    if (!phoneInputs.length) return;

    function onlyDigits(value) {
        return (value || '').replace(/\D/g, '');
    }

    function isValidPhone(input) {
        var digits = onlyDigits(input.value);
        return digits.length >= 10 && digits.length <= 12;
    }

    phoneInputs.forEach(function (input) {
        input.setAttribute('autocomplete', 'tel');
        input.setAttribute('inputmode', 'tel');

        input.addEventListener('input', function () {
            input.value = input.value.replace(/[^0-9+()\-\s]/g, '');
            input.setCustomValidity('');
        });

        input.addEventListener('blur', function () {
            var digits = onlyDigits(input.value);
            if (!digits) {
                input.value = '';
                input.setCustomValidity('');
                return;
            }
            if (!isValidPhone(input)) {
                input.setCustomValidity('Введите корректный номер (10-12 цифр).');
            } else {
                input.setCustomValidity('');
            }
            input.reportValidity();
        });
    });

    document.addEventListener(
        'submit',
        function (event) {
            var form = event.target;
            if (!(form instanceof HTMLFormElement)) return;

            var tel = form.querySelector('input[type="tel"]');
            if (!tel) return;

            if (!isValidPhone(tel)) {
                tel.setCustomValidity('Введите корректный номер (10-12 цифр).');
                tel.reportValidity();
                event.preventDefault();
                return;
            }

            tel.setCustomValidity('');
        },
        true
    );
});
