<?php $this->view("map/include/header"); ?>

    <map name="info">
        <area shape="rect" coords="0,0,4241,2601" alt="Quadra 1" href="<?= BASE_URL; ?>quadra/1">
        <area shape="rect" coords="633,2681,6345,6561" alt="Quadra 2" href="<?= BASE_URL; ?>quadra/2">
    </map>


    <section class="pg-inicial">
        <img src="<?= BASE_STORANGE; ?>assets/img/map/inteiro.png" usemap="#info" id="minhaImg" />
    </section>


<?php $this->view("map/include/footer"); ?>

<script>
    $('#minhaImg[usemap]').rwdImageMaps();
</script>

