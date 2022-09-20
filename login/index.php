<?php
require 'conexao.php';

// usando funçaão nativa do php que verifca se existe um post email ou senha; 
if (isset($_POST['email']) || isset($_POST['senha'])) {

    // verifica se email e senha estão em branco;
    if (strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail!";
    } else if (strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha!";
    } else {

        // usando a função addslashes para limpar a string afim de evitar sql injection.
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);


        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha") or die("falha na execucao da query");
        $sql->bindValue(':email', $email);
        $sql->bindValue(':senha', $senha);
        $sql->execute();
        // verifica se existe o usuario no banco.
        if ($sql->rowCount() > 0) {


            $usuario = $sql->fetch(PDO::FETCH_ASSOC);
            // se nao existir uma sessão inicia uma;
            if (!isset($_SESSION)) {
                session_start();
            }
            // A variavel $_SESSION pode estar presente em mais de uma pagina durante a sessão.
            // pega os dados do usuario [id e nome] para utilizar durante a sessão. 
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: painel.php");
        } else {

            echo "Falha ao logar! E-mail ou senha incorretos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
   
</head>

<body>
    <h1>Acesse sua conta</h1>
    <form action="" method="POST">

        <label for="email">E-mail:</label>
        <input type="email" name="email" placeholder="Digite seu email" required minlength="6" />

        <label for="">Senha:</label>
        <input type="password" name="senha" required minlength="3" />

        <input type="submit" value="Entrar" />
    </form>
</body>

</html>