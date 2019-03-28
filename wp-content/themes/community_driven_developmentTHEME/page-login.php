<div class="login-branding">
  <a href="#" class="login-logo">Hongkiat.com</a>
  <p class="login-desc">
    Hongkiat.com is a design weblog dedicated to designers and bloggers. We constantly publish useful tricks, tools, tutorials and inspirational artworks.
  </p>
</div>
<div class="login-form">
<?php
$args = array(
    'redirect' => home_url(), 
    'id_username' => 'user',
    'id_password' => 'pass',
   ) 
;?>
<?php wp_login_form( $args ); ?>
</div>