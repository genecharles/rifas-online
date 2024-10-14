<?php echo $this->extend('Layouts/main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('css'); ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('content'); ?>
<div class="container">
	<?php if(empty($raffles)): ?>
		<div class="text-center text-info display-6">Não há rifas disponíveis para compra </div>
		<?php else: ?>

			<div class="row">

				<?php foreach ($raffles as $raffle): ?>

					<div class="col-md-4 mb-2">

						<div class="card shadow-lg">

							<div class="card-body">

								<div class="card-title"><?php echo $raffle->title; ?></div>
								<div class="card-text"><?php echo $raffle->description; ?></div>

							</div>
							<ul class="list-group list-group-flush">

								<li class="list-group-item">Data do Sorteio: <?php echo $raffle->draw_date; ?></li>
								<li class="list-group-item">Bilhete (número) restantes: <?php echo $raffle->ticketsRemaining(); ?></li>
								<li class="list-group-item">Valor do Bilhete: <?php echo $raffle->price(); ?></li>

							</ul>
							<div class="card-body">
								<div class="container">
									<a href="<?php echo route_to('tickets', $raffle->code) ?>" class="btn btn-danger">Escolha seus Números</a>
								</div>

								<ul class="list-group list-group-flush">

									<?php $counter = 0; ?>

									<?php foreach ($raffle->prizes as $prize):?>

										<?php if($counter === 0) : ?>

											<li class="list-group-item border-0">
												<img src="<?php echo $prize->image_url; ?>" alt="Image" class="card-img-top img-fluid">
												<div class="card-body">
													<h5><?php echo $prize->title; ?></h5>
													<p><?php echo $prize->description; ?></p>
												</div>
											</li>

											<?php break; ?>

										<?php endif; ?>

										<?php $counter++; ?>

									<?php endforeach; ?>

								</ul>

							</div>
						</div>
					</div>
				<?php endforeach; ?>

			</div>

		<?php endif; ?>
	</div>
	<?php echo $this->endSection(); ?>

	<?php echo $this->section('js'); ?>

	<?php echo $this->endSection(); ?>