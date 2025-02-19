import IMask from 'imask';

document.addEventListener('DOMContentLoaded', function() {
    // Máscara de CNPJ
    const cnpjElement = document.getElementById('cnpj');
    if (cnpjElement) {
        IMask(cnpjElement, {
            mask: '00.000.000/0000-00',
            // Impede digitação após completar
            maxLength: 18,
            // Permite apenas números
            prepare: str => str.replace(/\D/g, '')
        });
    }

    // Máscara de Telefone (implementação mais robusta)
    const phoneElement = document.getElementById('phone');
    if (phoneElement) {
        const phoneMask = IMask(phoneElement, {
            mask: [
                {
                    mask: '(00) 0000-0000',
                    maxLength: 14
                },
                {
                    mask: '(00) 00000-0000',
                    maxLength: 15
                }
            ]
        });
    }
});