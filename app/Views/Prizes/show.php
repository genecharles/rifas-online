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
    			<a href="<?php echo route_to('prizes') ?>" class="btn btn-secondary float-start">Voltar</a>
    		</div>

    		<div class="card-body">

                <ul class="list-group mb-4">

                    <li class="list-group-item active"><?php echo $prize->title; ?></li>
                    <li class="list-group-item "><strong>Imagem: </strong><br><?php echo $prize->imageUrl(500); ?></li>
                    <li class="list-group-item "><strong>Criado: </strong><?php echo $prize->created_at->humanize(); ?></li>
                    <li class="list-group-item "><strong>Atualizado: </strong><?php echo $prize->updated_at->humanize(); ?></li>
                    <li class="list-group-item "><strong>Descrição: </strong><?php echo $prize->description; ?></li>
                    <li class="list-group-item "><strong>Rifas: </strong><?php echo $prize->raffles(); ?></li>

                </ul>

                <a href="<?php echo route_to('prizes.edit', $prize->code) ?>" class="btn btn-primary">Editar</a>

                    <?php echo form_open(
                    action: route_to('prizes.destroy', $prize->code), 
                    attributes:['class' => 'c-inline', 'onsubmit' => 'return confirm("Tem certeza da exclusão?");'],
                    hidden: ['_method' => 'DELETE']
                ); ?>


                    <button type="submit" class="btn btn-danger">Excluir</button>

                    <?php echo form_close(); ?>
		

    		</div>

    	</div>

  </div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
    

<?php echo $this->endSection(); ?>