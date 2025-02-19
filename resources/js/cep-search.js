document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('zip_code');
    const addressInput = document.getElementById('address');
    const neighborhoodInput = document.getElementById('neighborhood');
    const cityInput = document.getElementById('city');
    const stateInput = document.getElementById('state');
    const loadingElement = document.getElementById('cep-loading');

    if (cepInput) {
        let timeoutId;

        cepInput.addEventListener('input', function() {
            // Remove tudo que não é número
            this.value = this.value.replace(/\D/g, '');
            
            // Adiciona o hífen
            if (this.value.length > 5) {
                this.value = this.value.substring(0, 5) + '-' + this.value.substring(5);
            }

            // Limita ao tamanho máximo
            if (this.value.length > 9) {
                this.value = this.value.substring(0, 9);
            }

            // Consulta CEP após 500ms sem digitação
            clearTimeout(timeoutId);
            if (this.value.length === 9) { // Com hífen
                timeoutId = setTimeout(() => consultaCEP(this.value), 500);
            }
        });

        async function consultaCEP(cep) {
            // Remove o hífen para a consulta
            cep = cep.replace('-', '');
            
            if (cep.length !== 8) return;

            try {
                // Mostra loading
                loadingElement.classList.remove('hidden');
                
                // Desabilita campos durante a consulta
                [addressInput, neighborhoodInput, cityInput, stateInput].forEach(input => {
                    input.disabled = true;
                });

                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (!data.erro) {
                    addressInput.value = data.logradouro;
                    neighborhoodInput.value = data.bairro;
                    cityInput.value = data.localidade;
                    stateInput.value = data.uf;

                    // Foca no campo número após preenchimento
                    document.getElementById('number').focus();
                } else {
                    alert('CEP não encontrado. Por favor, verifique o número informado.');
                }
            } catch (error) {
                console.error('Erro ao consultar CEP:', error);
                alert('Erro ao consultar CEP. Por favor, tente novamente.');
            } finally {
                // Esconde loading
                loadingElement.classList.add('hidden');
                
                // Reabilita campos
                [addressInput, neighborhoodInput, cityInput, stateInput].forEach(input => {
                    input.disabled = false;
                });
            }
        }
    }
});