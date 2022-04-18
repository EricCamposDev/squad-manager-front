<?php
  
  if( isset($_GET["alert"]) and !empty($_GET['alert']) ):
    $alert = explode("=", base64_decode($_GET["alert"]));
    $theme = ($alert[0]==1) ? 'success' : 'danger';
    $title = ($alert[0]==1) ? 'Sucedido' : 'Falha';

?>
    <div class="alert alert-<?=$theme; ?> alert-dismissible fade show" role="alert">
      <strong><?=$title; ?></strong> <?=$alert[1]; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
  endif;
?>