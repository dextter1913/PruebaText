<?php 
require_once 'app\Login\models\app_autoload.php';
    class controller  
    {
        public static function Login(){
            require_once 'app\Login\views\assets\header.html';
            require_once 'app\Login\views\modules\login.phtml';

            if (isset($_POST['btnIniciarSession'])) {

                $user = $_POST['user'];
                $pass = md5($_POST['pass']);

                $validacion1 = mysqli_num_rows(crud::Read(query::ValidacionLoginMaster($user,$pass)));
                $validacion2 = mysqli_num_rows(crud::Read(query::ValidacionLoginAdmin($user,$pass)));
                $validacion3 = mysqli_num_rows(crud::Read(query::ValidacionLoginAsistant($user,$pass)));

                if ($validacion1) {
                    $_SESSION['Master'] = $user;
                    header('Location:./');
                }elseif ($validacion2) {
                    $_SESSION['Admin'] = $user;
                    header('Location:./');
                }elseif ($validacion3) {
                    $_SESSION['Asistant'] = $user;
                    header('Location:./');
                }else {
                    echo '<center class="text-danger"><b>Usuario o Contraseña invalido</b></center>';
                }
            }
            require_once 'app\Login\views\assets\footer.html';
        }
    }
