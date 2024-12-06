<?php include('assets/layouts/header.php'); ?>

<div class="container mt-5">
    <h1 style="color: black;">Qual é o seu signo?</h1>

    <form id="signo-form" method="POST" action="show_zodiac_sign.php">
        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Informe sua data de nascimento</label> <br>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
        </div>
        <div class="text-center">
    <button type="submit" class="btn" style="background-color: #007bff; color: white; border-radius: 25px;">Ver meu signo</button>
</div>

    </form>
</div>

<?php include('assets/layouts/footer.php'); ?>

Arquivo show_zodiac_sign.php 
<?php include('assets/layouts/header.php'); ?>

<div class="container mt-5 text-center">
    <h1 style="color: black;">O seu signo é:</h1>

    <?php
    $data_nascimento = $_POST['data_nascimento'];
    $signos = simplexml_load_file("signos.xml");
    $data_nascimento = new DateTime($data_nascimento);
    $signo_encontrado = false;

    foreach ($signos->signo as $signo) {
        $data_inicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio);
        $data_fim = DateTime::createFromFormat('d/m', (string)$signo->dataFim);
        $data_inicio->setDate($data_nascimento->format('Y'), $data_inicio->format('m'), $data_inicio->format('d'));
        $data_fim->setDate($data_nascimento->format('Y'), $data_fim->format('m'), $data_fim->format('d'));
        
        if ($data_inicio > $data_fim) {
            $data_fim->modify('+1 year');
            if ($data_nascimento < $data_inicio && $data_nascimento > $data_fim) {
                continue;
            }
        }
        
        if ($data_nascimento >= $data_inicio && $data_nascimento <= $data_fim) {
            echo "<h2 style='color: #007bff;'>{$signo->signoNome}</h2>";
            echo "<p style='color: white;'>{$signo->descricao}</p>";
            $signo_encontrado = true;
            break;
        }
    }

    if (!$signo_encontrado) {
        echo "<p style='color: white;'>Não foi possível determinar seu signo. Verifique a data informada.</p>";
    }
    ?>
    
    <a href="index.php" class="btn" style="background-color: #007bff; color: white; border-radius: 25px; width: 100px;">Voltar</a>


</div>

<?php include('assets/layouts/footer.php'); ?>