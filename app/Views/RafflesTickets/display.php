<?php echo $this->extend('Layouts/main'); ?>


<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('css'); ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>


<div class="container">


    <div class="card shadow-lg">

        <div class="card-body">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Números</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Premiações</button>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="<?php echo route_to('home'); ?>" class="nav-link">Escolher rifa</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="mt-3 container">

                        <h5 class="text-muted display-6"><?php echo $raffle->title; ?></h5>

                        <?php if ((int) $raffle->creator_id === (int) user_id()) : ?>
                            <div class="badge bg-warning text-dark mb-2">Você criou essa rifa</div>
                        <?php endif ?>

                        <p>Valor do número: <?php echo $raffle->price(); ?></p>

                        <button type="button" id="btnConfirm" class="btn btn-lg btn-danger mt-4" disabled>Escolha seus números</button>

                        <p class="display-6">Valor a pagar: <strong id="totalSum"></strong></p>

                    </div>


                    <!-- Receberá os números via javascript -->
                    <div id="buttonsContainer" class="container"></div>

                </div>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    <ul class="list-group list-group-horizontal">

                        <?php foreach ($raffle->prizes as $prize) : ?>

                            <li class="list-group-item border-0">

                                <img src="<?php echo $prize->image_url; ?>" class="card-img-top img-fluid" alt="<?php echo $prize->title; ?>">
                                <div class="card-body">
                                    <h5><?php echo $prize->title; ?></h5>
                                    <p><?php echo $prize->description; ?></p>
                                </div>

                            </li>

                        <?php endforeach; ?>

                    </ul>


                </div>

            </div>

        </div>


    </div>

</div>


<?php echo $this->endSection(); ?>


<?php echo $this->section('js'); ?>

<script>
    // botão ir para confirmação
    btnConfirm = document.getElementById('btnConfirm');

    // valor por número (ticket)
    const price = '<?php echo $raffle->price; ?>';

    // Obtém o elemento que mostrará o total a ser pago e inicializa com R$ 0,00
    const totalSumDiv = document.getElementById('totalSum');
    totalSumDiv.innerHTML = 'R$ 0,00';

    let totalSum = 0; // Inicializa a variável para armazenar o total

    // Obtém os IDs (números) dos tickets disponíveis do PHP e converte para JSON
    const ticketsAvailables = <?php echo json_encode($raffle->tickets_availables); ?>;

    // Obtém o container dos botões
    const buttonsContainer = document.getElementById('buttonsContainer');

    // Array para armazenar os números selecionados
    const selectedNumbers = [];

    // Itera sobre os IDs dos tickets disponíveis
    ticketsAvailables.forEach(ticketId => {
        // Cria um botão para cada ID de ticket
        const button = document.createElement('button');

        // valor do botão
        button.textContent = ticketId;

        // Adiciona a classe 'btn' e 'btn-sm' ao botão
        button.className = 'btn btn-lg btn-primary m-2 px-3';

        // Adiciona um evento de clique ao botão
        button.addEventListener('click', function() {

            if (!button.disabled) {

                // converte o valor de price para centavos, dividindo o valor por 100.
                const priceInCents = parseInt(price) / 100;

                // atualiza a variável totalSum somando ou subtraindo o valor de priceInCents com base na classe do botão. 
                // Se o botão contém a classe 'btn-danger', subtrai o valor, caso contrário, soma o valor.
                totalSum += button.classList.contains('btn-danger') ? -priceInCents : priceInCents;

                // exibimos o valor na div
                totalSumDiv.innerHTML = totalSum.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL',
                    minimumFractionDigits: 2
                });

                if (button.classList.contains('btn-danger')) {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-primary');

		    // Remove o número selecionado do array
                    const index = selectedNumbers.indexOf(ticketId);
                    if (index !== -1) {
                        selectedNumbers.splice(index, 1);
                    }
                } else {
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-danger');
                    selectedNumbers.push(ticketId);
                }

                console.log(selectedNumbers);

                // habilitamos ou não com base nos números selecionados
                btnConfirm.disabled = (selectedNumbers.length === 0);
                btnConfirm.textContent = selectedNumbers.length === 0 ? 'Escolha seus números' : 'Ir para pagamento';
                btnConfirm.className = selectedNumbers.length === 0 ? 'btn btn-lg btn-danger mt-4' : 'btn btn-lg btn-dark mt-4';
            }
        });

        buttonsContainer.appendChild(button);
    });
</script>


<script>
    // Adicione o evento de clique ao botão 'btnConfirm' para enviar os 'selectedNumbers' via fetch API e redirecionar
    const btnConfirm = document.getElementById('btnConfirm');
    btnConfirm.addEventListener('click', function() {

        if (selectedNumbers.length === 0) {

            // nada fazemos, pois não foi escolhido números
            return;
        }

        // CSRF CODE PARA ENVIAR NO REQUEST
        let csrfTokenName = '<?php echo csrf_token(); ?>';
        let csrfTokenValue = '<?php echo csrf_hash(); ?>';

        const bodyRequest = {
            selected_numbers: selectedNumbers
        };

        // colocamos no body os dados de CSRF
        bodyRequest[csrfTokenName] = csrfTokenValue;

        fetch('<?php echo route_to('tickets.reserve.numbers'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(bodyRequest)
            })
            .then(response => response.json())
            .then(data => {

                // redirecionamos para a view de confirmação
                window.location.href = '<?php echo route_to('tickets.confirm', $raffle->code); ?>';
            })
            .catch(error => {
                console.error('Erro ao enviar requisição:', error);
                alert('Erro ao enviar os dados');
            });

    });
</script>


<?php echo $this->endSection(); ?>