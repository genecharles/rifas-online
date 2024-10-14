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
                <a href="<?php echo route_to('raffles.new') ?>" class="btn btn-success float-end">Nova Rifa</a>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table">

                        <thead>
                            <tr>
                                <th>Açoes</th>
                                <th>Titulo</th>
                                <th>Data Sorteio</th>
                                <th>Números Vendidos</th>
                                <th>Status</th>
                            </tr>
                        </thead>


                        <tbody>

                            <?php foreach($raffles as $raffle): ?>

                                <tr>
                                    <td>
                                        <a href="<?php echo route_to('raffles.show', $raffle->code) ?>" class="btn btn-info">Detalhes</a>
                                    </td>
                                    <td><?php echo $raffle->title; ?></td>
                                    <td><?php echo $raffle->draw_date; ?></td>
                                    <td><?php echo $raffle->sold_tickets; ?></td>
                                    <td><?php echo $raffle->status(); ?></td>
                                </tr>
                                
                            <?php endforeach ?>
                            
                        </tbody>
                        
                    </table>
                    
                </div>

            </div>

        </div>

  </div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>

<?php echo $this->endSection(); ?>