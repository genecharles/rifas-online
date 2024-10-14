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
                <a href="<?php echo route_to('prizes.new') ?>" class="btn btn-success float-end">Novo Prêmio</a>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table">

                        <thead>
                            <tr>
                                <th>Açoes</th>
                                <th>Titulo</th>
                                <th>Descrição</th>
                                <th>Criado</th>
                            </tr>
                        </thead>


                        <tbody>

                            <?php foreach($prizes as $prize): ?>

                                <tr>
                                    <td>
                                        <a href="<?php echo route_to('prizes.show', $prize->code) ?>" class="btn btn-info">Detalhes</a>
                                    </td>
                                    <td><?php echo $prize->title; ?></td>
                                    <td><?php echo ellipsize($prize->description, maxLength: 50); ?></td>
                                    <td><?php echo $prize->created_at->humanize(); ?></td>
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