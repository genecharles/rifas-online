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

    			<a href="<?php echo route_to('home') ?>" class="btn btn-secondary float-start">Escolher rifas</a>
    		</div>

    		<div class="card-body">

                <ul class="list-group mb-4">

                    <li class="list-group-item active"><?php echo $raffle->title; ?></li>
                    
                    <li class="list-group-item "><strong>Data do sorteio: </strong><?php echo $raffle->draw_date; ?></li>
                    <li class="list-group-item "><strong>Status: </strong><?php echo $raffle->status(); ?></li>
                    <li class="list-group-item "><strong>Vencedor: </strong><?php echo $raffle->isClosed() ? $raffle->status() : ($raffle->winning_raffle ? 'Você foi premiado' : 'Não foi dessa vez'); ?></li>
                    <li class="list-group-item "><strong>Número campeão: </strong><?php echo $raffle->winningNumber(); ?></li>
                    <li class="list-group-item "><strong>Tickets: </strong><?php echo $raffle->tickets(); ?></li>
                    <li class="list-group-item "><strong><?php echo $raffle->winning_raffle ? 'Olha o que você ganhou' : 'Prêmios da rifa'; ?></strong><?php echo $raffle->prizes(showRoute: false); ?></li>

                </ul>

                <a href="<?php echo route_to('raffles.prizes', $raffle->code) ?>" class="btn btn-secondary">Gerenciar prêmios</a>

                <?php if($raffle->sold_tickets < 1): ?>

                    <?php echo form_open(
                    action: route_to('raffles.destroy', $raffle->code), 
                    attributes:['class' => 'c-inline', 'onsubmit' => 'return confirm("Tem certeza da exclusão?");'],
                    hidden: ['_method' => 'DELETE']
                ); ?>


                    <button type="submit" class="btn btn-danger">Excluir</button>

                    

                    <?php echo form_close(); ?>

                <?php endif ?>



    			

    		</div>

    	</div>

  </div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
    

<?php echo $this->endSection(); ?>