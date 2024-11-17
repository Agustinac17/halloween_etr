<?php
include('basededatos/conexion.php');
conectar();
session_start();
?>
<style>

.disfraz img {
    width: 100%; 
    max-width: 300px; 
    height: auto; 
    border-radius: 15px; 
    border: 2px solid #c71313; 
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5); 
    transition: transform 0.3s, box-shadow 0.3s; 
}

.disfraz img:hover {
    transform: scale(1.05); 
    box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.7); 
}


.disfraz {
    margin: 20px auto; 
    padding: 15px;
    max-width: 600px; 
    text-align: center; 
    border: 1px solid #e0e0e0; 
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
}

#disfraces-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px; 
    padding: 20px;
}

</style>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HALLOWEEN</title>

    <!-- Enlaces a hojas de estilo CSS -->
    <link rel="stylesheet" href="estilos/estilosind.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <!-- Barra de navegación o menú -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand">Concurso de Halloween</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="ml-auto">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="index.php">Ver Disfraces</a></li>
            <li><a href="index.php?modulo=registro">Registro</a></li>
            <li><a href="index.php?modulo=login">Iniciar Sesión</a></li>
            <li><a href="index.php?modulo=paneladmin">Panel de Administración</a></li>
        </ul>
        </div>
    </nav>

    <header>
        <h1>Concurso de disfraces de Halloween</h1>
    </header>
    <?php
        if(!empty($_SESSION['nombre_usuario']))
        {
            ?>
            <p>Hola <?php echo $_SESSION['nombre_usuario'];?>. usted tiene el ID: <?php echo $_SESSION['id'];?></p>
            <a href="index.php?modulo=login&salir=ok">SALIR</a>
            <?php
        }
    ?>

<main>
    <?php
    if(!empty($_GET['modulo']))
    {
        include('modulos/'.$_GET['modulo'].'.php');
    }
    else
            {
                $sql = "SELECT *FROM disfraces WHERE eliminado=0 ORDER BY votos DESC";
                $sql = mysqli_query($con, $sql);
                if(mysqli_num_rows($sql) != 0)
                {
                    while ($r = mysqli_fetch_array($sql)) 
                    {
                        ?>
                        <section id="disfraces-list" class="section">
                            <!-- Aquí se mostrarán los disfraces -->
                            <div class="disfraz">
                                <h2><?php echo $r['nombre'];?></h2>
                                <p><?php echo $r['descripcion'];?></p>
                                <p>Votos: <?php echo $r['votos'];?></p>
                                <?php
                                if(file_exists('imagenes/'.$r['foto']))
                                {
                                    //unlink('imagenes/'.$r['foto']);//borro las fotos
                                    ?>
                                        <p><img src="imagenes/<?php echo $r['foto'];?>" width="100%"></p>
                                        <!--<p>FOTO BLOB</p>
                                        <p><img src="modulos/mostrar_foto.php?id=<?php //echo $r['id'];?>" width="100%"></p>-->
                                    <?php 
                                }
                                    else
                                    {
                                        echo "<p>Sin fotos</p>";
                                    }
                                ?>
                                
                                <?php
                                if(!empty($_SESSION['id_usuario']))
                                {
                                    //consulto si el usuario voto por el disfraz
                                    $sql_votos = "SELECT *FROM votos where id_disfraz=".$r['id']." and id_usuario=".$_SESSION['id'];
                                    $sql_votos = mysqli_query($con, $sql_votos);
                                    if(mysqli_num_rows($sql_votos) == 0)
                                    {
                                        ?>
                                            <button class="votar" id="votarBoton<?php echo $r['id'];?>" onclick="votar(<?php echo $r['id'];?>)">Votar</button>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
            
                        </section>
                        <?php
                    }
                }
                    else
                    {
                        ?>
                        <section id="disfraces-list" class="section">
                            <!-- Aquí se mostrarán los disfraces -->
                            <div class="disfraz">
                                <h2>No hay datos.</h2>
                            </div> 
                            <!-- Repite la estructura para más disfraces -->
                        </section>
                        <?php
                    }
            }
        ?>

    </main>

    <script src="js/js.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
