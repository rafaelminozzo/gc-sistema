document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('zip_code');
    const addressInput = document.getElementById('address');
    const neighborhoodInput = document.getElementById('neighborhood');
    const cityInput = document.getElementById('city');
    const stateInput = document.getElementById('state');
    const loadingElement = document.getElementById('cep-loading');

    if (cepInput) {
        let timeoutId;
        const fields = [addressInput, neighborhoodInput, cityInput, stateInput];

        cepInput.addEventListener('blur', async function() {
            const cep = this.value.replace(/\D/g, '');
            
            if (cep.length !== 8) return;

            try {
                // Mostra loading
                loadingElement?.classList.remove('hidden');
                fields.forEach(field => {
                    if (field) field.classList.add('opacity-50');
                });

                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (!data.erro) {
                    if (addressInput) addressInput.value = data.logradouro || '';
                    if (neighborhoodInput) neighborhoodInput.value = data.bairro || '';
                    if (cityInput) cityInput.value = data.localidade || '';
                    if (stateInput) stateInput.value = data.uf || '';

                    // Se endereço foi encontrado, foca no número
                    const numberInput = document.getElementById('number');
                    if (data.logradouro && numberInput) {
                        numberInput.focus();
                    }
                } else {
                    alert('CEP não encontrado. Por favor, verifique o número informado.');
                }
            } catch (error) {
                console.error('Erro ao consultar CEP:', error);
                alert('Erro ao consultar CEP. Por favor, tente novamente.');
            } finally {
                // Remove loading
                loadingElement?.classList.add('hidden');
                fields.forEach(field => {
                    if (field) field.classList.remove('opacity-50');
                });
            }
        });
    }
});