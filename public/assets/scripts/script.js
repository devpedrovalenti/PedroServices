// public/assets/scripts/script.js

document.addEventListener('DOMContentLoaded', () => {
    const inputData = document.getElementById('data');
    const gridHorarios = document.getElementById('grid-horarios');
    const inputHorarioOculto = document.getElementById('horario_selecionado');
    const formAgendamento = document.getElementById('form-agendamento');

    // Quando o usuário escolhe uma data
    inputData.addEventListener('change', (e) => {
        const dataSelecionada = e.target.value;
        
        if (dataSelecionada) {
            carregarHorarios(dataSelecionada);
        } else {
            gridHorarios.innerHTML = '<span class="placeholder-msg">Selecione uma data para ver os horários.</span>';
            inputHorarioOculto.value = '';
        }
    });

    // Função que vai buscar/gerar os horários
    function carregarHorarios(data) {
        // Aqui, futuramente, faremos um Fetch (AJAX) para o PHP buscando do banco.
        // Por enquanto, vamos simular uma resposta do servidor.
        gridHorarios.innerHTML = '<span class="placeholder-msg">Buscando horários...</span>';

        setTimeout(() => {
            // Horários fictícios (mock)
            const horariosDisponiveis = ['09:00', '09:30', '10:00', '11:00', '14:00', '15:30', '16:00'];
            
            gridHorarios.innerHTML = ''; // Limpa a grid

            if (horariosDisponiveis.length === 0) {
                gridHorarios.innerHTML = '<span class="placeholder-msg">Nenhum horário disponível para esta data.</span>';
                return;
            }

            horariosDisponiveis.forEach(hora => {
                const divSlot = document.createElement('div');
                divSlot.classList.add('slot-horario');
                divSlot.textContent = hora;
                
                // Adiciona o evento de clique para selecionar o horário
                divSlot.addEventListener('click', () => {
                    // Remove a classe 'selecionado' de todos
                    document.querySelectorAll('.slot-horario').forEach(el => el.classList.remove('selecionado'));
                    // Adiciona no clicado
                    divSlot.classList.add('selecionado');
                    // Salva o valor no input hidden para enviar via POST
                    inputHorarioOculto.value = hora;
                });

                gridHorarios.appendChild(divSlot);
            });
        }, 500); // Simulando delay de rede
    }

    // Validação antes do envio
    formAgendamento.addEventListener('submit', (e) => {
        if (!inputHorarioOculto.value) {
            e.preventDefault();
            alert('Por favor, selecione um horário disponível antes de confirmar!');
        }
    });
});