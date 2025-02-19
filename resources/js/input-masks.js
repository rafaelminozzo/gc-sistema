import IMask from 'imask';

document.addEventListener('DOMContentLoaded', function() {
    // Máscara de CEP
    const cepElement = document.getElementById('zip_code');
    if (cepElement) {
        IMask(cepElement, {
            mask: '00000-000',
            // Impede digitação após completar
            maxLength: 9,
            // Permite apenas números
            prepare: str => str.replace(/\D/g, '')
        });
    }

    // Máscara de CNPJ
    const cnpjElement = document.getElementById('cnpj');
    if (cnpjElement) {
        IMask(cnpjElement, {
            mask: '00.000.000/0000-00',
            maxLength: 18,
            prepare: str => str.replace(/\D/g, '')
        });
    }

    // Máscara de Telefone
    const phoneElement = document.getElementById('phone');
    if (phoneElement) {
        IMask(phoneElement, {
            mask: [
                {
                    mask: '(00) 0000-0000'
                },
                {
                    mask: '(00) 00000-0000'
                }
            ]
        });
    }
});