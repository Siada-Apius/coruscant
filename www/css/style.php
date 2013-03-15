<style type="text/css">

    .lightSaber{

        background-color: #000;
        width: 75px;
        height: 204px;

    }

    .left, .right{

        display: inline-block;

    }

    .blade<?php echo $uniqueId; ?>{

        <?php if($a == 0): ?>
        height: 117px;
        <?php endif; ?>

        <?php if($b == 0): ?>
        height: 117px;
        <?php endif; ?>

    }

    .topBlue<?php echo $uniqueId; ?>, .topRed<?php echo $uniqueId; ?>{

        background-repeat: no-repeat;
        min-height: 20px;
        width: 35px;

    }

    .middleBlue<?php echo $uniqueId; ?>, .middleRed<?php echo $uniqueId; ?>{

        width: 35px;

    }

    .downBlue<?php echo $uniqueId; ?>, .downRed<?php echo $uniqueId; ?>{

        background-repeat: no-repeat;
        height: 82px;
        width: 35px;

    }
        /*------------------------------------------------------------*/




    .topBlue<?php echo $uniqueId; ?>{

        <?php if ($a !== 0): ?>
        background-image: url("/img/style/sabers/blue/bladeBig.png");
        <?php endif; ?>

    }

    .middleBlue<?php echo $uniqueId; ?>{


        background-image: url("/img/style/sabers/blue/blade.png");
        height: <?php echo $proc1R . 'px'; ?>


    }

    .downBlue<?php echo $uniqueId; ?>{

        <?php if ($a == 0): ?>
        background-image: url("/img/style/sabers/blue/saber.png");
        height: 65px;
        <?php else: ?>
        background-image: url("/img/style/sabers/blue/saberBig.png");
        <?php endif; ?>

    }


    /*-------------------------------------------------------------*/


    .topRed<?php echo $uniqueId; ?>{

        <?php if ($b !== 0): ?>
        background-image: url("/img/style/sabers/red/bladeBig.png");
        <?php endif; ?>

    }

    .middleRed<?php echo $uniqueId; ?>{


        background-image: url("/img/style/sabers/red/blade.png");
        height: <?php echo $proc2R . 'px'; ?>


    }

    .downRed<?php echo $uniqueId; ?>{

        <?php if ($b == 0): ?>
        background-image: url("/img/style/sabers/red/saber.png");
        height: 65px;
        <?php else: ?>
        background-image: url("/img/style/sabers/red/saberBig.png");
        <?php endif; ?>

    }

</style>