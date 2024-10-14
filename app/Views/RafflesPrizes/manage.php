<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>

<!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" /> -->



<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>

	<div class="container">

    	<div class="card shadow-lg">

    		<div class="card-header">
    			<h4 class="card-title"><?php echo $title ?></h4>
    			<a href="<?php echo route_to('raffles') ?>" class="btn btn-secondary float-start">Listar minhas rifas</a>
    		</div>

    		<div class="card-body">

                <ul class="list-group mb-4">

                    <li class="list-group-item active"><?php echo $raffle->title; ?></li>
                    <li class="list-group-item "><strong>Preço por bilhete: </strong><?php echo $raffle->price(); ?></li>
                    <li class="list-group-item "><strong>Bilhetes (números) gerados: </strong><?php echo $raffle->total_tickets; ?></li>
                    <li class="list-group-item "><strong>Bilhetes (números) vendidos: </strong><?php echo $raffle->sold_tickets; ?></li>
                    <li class="list-group-item "><strong>Bilhetes (números) restantes: </strong><?php echo $raffle->ticketsRemaining(); ?></li>
                    <li class="list-group-item "><strong>Data do sorteio: </strong><?php echo $raffle->draw_date; ?></li>
                    <li class="list-group-item "><strong>Prêmios associados: </strong><?php echo $raffle->prizes(); ?></li>

                </ul>

                

              

                <?php echo form_open(
                    action: route_to('raffles.prizes.store', $raffle->code), 
                    attributes:['class' => 'd-inline'],
                    hidden: ['_method' => 'PUT']
                ); ?>

                <div class="mb-3">
                    <label for="prizes[]">Escolha os prêmios</label>
                    <?php echo $prizesOptions; ?>
                </div>


                    <button type="submit" class="btn btn-primary">Associar Prêmios</button>                    

                    <?php echo form_close(); ?>    			

    		</div>

    	</div>

  </div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
    
    <!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('#prizes').select2({
        theme: 'bootstrap-5',
        placeholder: '--- Escolha um ou mais prêmios ---',
    });
</script>

<?php echo $this->endSection(); ?>