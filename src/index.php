<?php
  include('templates/tpl_common.php');
  include('templates/tpl_main.php');

  session_start();

  draw_head();
  draw_header();
  draw_aside();
  draw_animal_profiles();
  draw_footer();
?>
