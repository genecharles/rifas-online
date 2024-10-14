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

            <h4><?php echo $title; ?></h4>

            <a href="<?php echo route_to('tickets', $raffle->code) ?>" class="btn btn-secondary">Escolher os números novamente</a>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="mb-3 col-md-12">
                    <h5 class="text-muted mb-3"><?php echo $raffle->title; ?></h5>
                    <h6>Você escolheu os seguinte números:</h6>
                    <p class="display-6"><?php echo $numbers; ?></p>
                </div>

                <?php echo form_open(route_to('tickets.pay.numbers', $raffle->code)); ?>


                    <div class="mb-3 col-md-12">

                        <label for="payment_method">Escolha a forma de pagamento</label>

                        <?php echo $paymentMethodsOptions; ?>
                        
                    </div>


                    <button type="submit" id="btnPay" class="btn btn-success btn-lg mt-4" disabled>Finalizar o pagamento de <?php echo $amountToPay; ?></button>


                <?php echo form_close(); ?>
                
            </div>
            
        </div>
        
    </div>

</div>


<?php echo $this->endSection(); ?>


<?php echo $this->section('js'); ?>
<script>
    document.getElementById('payment_method').addEventListener('change', function(){
        const selectedValue = this.value;
        const btnPay = document.getElementById('btnPay');

        btnPay.disabled = !selectedValue;
    });
</script>



<?php echo $this->endSection(); ?>