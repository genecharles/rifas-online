<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>

	<div class="container">

    	<div class="card shadow-lg">

    		<div class="card-header">
    			<h4 class="card-title"><?php echo $title ?></h4>
    			<a href="<?php echo route_to('raffles') ?>" class="btn btn-secondary float-start">Listar minhas rifas</a>
    		</div>

    		<div class="card-body">

    			<?php echo form_open(
                    action: route_to('raffles.create'), 
                    attributes:['onsubmit' => 'return confirm("Os dados estão corretos? \n\n Não será possível editar uma rifa");']); ?>

                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label for="title">Título da rifa</label>
                            <input type="text" class="form-control" name="title" placeholder="Título" value="<?php echo old('title', $raffle->title); ?>">
                        </div>

                        
                        <div class="col-md-3 mb-3">

                            <label for="price">Preço de cada número (bilhete)</label>
                            <input type="text" required class="form-control money" name="price" placeholder="Preço" value="<?php echo old('price', $raffle->price); ?>">
                        </div>

                        <div class="col-md-3 mb-3">

                            <label for="total_tickets">Total de números que serão gerados</label>
                            <input type="number" required class="form-control" min="1" name="total_tickets" placeholder="Total de números" value="<?php echo old('total_tickets', $raffle->total_tickets); ?>">
                        </div>


                        <div class="col-md-3 mb-3">

                            <label for="draw_date">Data do sorteio</label>
                            <input type="date" required class="form-control" name="draw_date" placeholder="" value="<?php echo old('draw_date', $raffle->draw_date); ?>">
                        </div>


                        <div class="col-md-12 mb-3">

                            <label for="description">Descrição</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Descrição" required><?php echo old('description', $raffle->description); ?></textarea>
                        </div>


                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-danger">Criar minha rifa</button>
                        </div>
                        
                    </div>

                <?php echo form_close(); ?>

    		</div>

    	</div>

  </div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
    <script>
    // formata para BRL

    // Função para formatar o número como BRL
    function formatarBRL(value) {
        const formatter = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
        return formatter.format(value / 100);
    }

    // Seleciona o input onde o número será digitado
    const input = document.querySelector('.money');

    // Função para aplicar a formatação ao carregar a página
    function formatarInput() {
        let value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        input.value = formatarBRL(value);
    }

    // Aplica a formatação ao carregar a página
    formatarInput();

    // Adiciona um event listener para formatar o número ao digitar
    input.addEventListener('input', function(event) {
        let value = event.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        event.target.value = formatarBRL(value);
    });
</script>

<?php echo $this->endSection(); ?>