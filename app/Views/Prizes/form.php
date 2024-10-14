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

    			<?php echo form_open(
                    action: $route, 
                    hidden: $hidden ?? []
                ); ?>

                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <label for="title">Título do Prêmio</label>
                            <input type="text" required class="form-control" name="title" placeholder="Título" value="<?php echo old('title', $prize->title); ?>">
                        </div>


                        <div class="col-md-12 mb-3">

                            <label for="image_url">Imagem do Prêmio</label>
                            <input type="text" required class="form-control" name="image_url" placeholder="URL da imagem do prêmio" value="<?php echo old('image_url', $prize->image_url); ?>">
                        </div>

                        <div class="col-md-12 mb-3">

                            <label for="description">Descrição</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Descrição" required><?php echo old('description', $prize->description); ?></textarea>
                        </div>


                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-danger"><?php echo $prize->code ? 'Atualizar' : 'Criar'; ?> meu prêmio</button>
                        </div>
                        
                    </div>

                <?php echo form_close(); ?>

    		</div>

    	</div>

  </div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('js'); ?>
    

<?php echo $this->endSection(); ?>