<?php
require_once ( '../Conection.php' );
session_start();
#SQL de verificação
$sqlConsult = 
"SELECT users_id, name_users, permition_users
   FROM users
  WHERE name_users     = '{$_POST['usuario']}'
    AND password_users = '{$_POST['senha']}';";

$response = $bd->Execute($sqlConsult);


if ( $response->RecordCount() > 0 ){
  $_SESSION["id_user"] = $response->fields['users_id']; 
  $_SESSION["data_hora_login"] = date("d/m/Y H:i:s");
  $_SESSION["data_hora_login"] = date("d/m/Y H:i:s");
  $_SESSION["nome"] = strtoupper($response->fields['name_users']);
  $_SESSION["administrador"] = $response->fields['permition_users'];
  $_SESSION['aba'] = "";

  header("Location: ../../view/pages/Begin/controller.php");
}else{
    ?>
    <script language='javascript' type='text/javascript'>
        alert( 'Usuario e/ou senha incorreto(s)' );
        history.back();
    </script>
    <?php
    
}
