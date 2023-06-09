<div class="divMenuVertival">
    <ul class="menuVertival">
    <?php
        if(isset($_SESSION['cliente'])){?>
            <li id="first">
                <img src="pic/usuario.png" alt="">
                <a class="profile" href="index.php?controller=cliente&action=miPerfil">Mi perfil</a>
            </li>
            <li id="second">
                <img src="pic/news.png" alt="">
                <a class="messages" href="index.php">Novedades </a>
            </li>
            <li id="third">
                <img src="pic/corazon.png" alt="">
                <a class="favoritos" href="index.php?controller=libro&action=favoritos">Mis favoritos</a>
            </li>
            <li id="fourth">
                <img src="pic/sent.png" alt="">
                <a class="pedidos" href="index.php?controller=pedido&action=misPedidos">Mis pedidos</a>
            </li>
        <?php
        }
        else{?>
            <li id="first">
                <img src="pic/libr.png" alt="">
                <a class="messages" href="index.php">Página Principal</a>
            </li>
            <li id="second">
                <img src="pic/news.png" alt="">
                <a class="favoritos" href="index.php">Novedades</a>
            </li>
            <li id="third">
                <img src="pic/perfil.png" alt="">
                <a class="favoritos" href="index.php?controller=cliente&action=logearCliente">Iniciar sesión</a>
            </li>
            <?php
        }
        ?>
    </ul>
</div>
  <?php
    foreach($rows as $row){
        $isbn = $row['ISBN'];
        ?>
        <div id="div1">
            <!-- Imagen -->
            <div class="divimagenLibro">
                <img class="img2" src="<?php echo $row['foto']?>" alt="">
            </div>
            <?php
            if(isset($_SESSION['cliente'])){
                if($row['favorito']==1){?>
                    <a href="index.php?controller=libro&action=NoEsFavorito&isbn=<?php echo $isbn; ?>"><img class="img1" src="pic/corazonRojo.png" alt=""></a>
                    <?php
                }
                else{?>
                    <a href="index.php?controller=libro&action=esFavorito&isbn=<?php echo $isbn; ?>"><img class="img1" src="pic/corazonNegro.png" alt=""></a>
                    <?php
                }
            }
            ?>

            <div itemscope itemtype="https://schema.org/Product" class="textoDetalle">
                <!-- Titulo -->
                <div itemprop="name" class="divTituloLibro">
                    <h1><?php echo $row['titulo']?></h1>
                </div>
                <!-- Autor -->
                <div class="divAutorLibro">
                    <h2><?php echo $row['autor'] ?></h2>
                </div>
                <div class="divEditLibro">
                <!-- Categoria  -->
                    <p class="categoria"><?php echo $row['nombre']?></p>
                <!-- Isbn y editorial -->
                    <p class="ediIsbn"><?php echo $row['editorial']." - ".$row['ISBN']?></p>
                </div>
                <!-- Descripcion -->
                <div  class="divDescriLibro">
                    <p><?php echo $row['descripcion']?></p>
                </div>

                <!-- Stock -->
                <?php
                if($row['stock']==0){
                    echo "<div class='divEditLibro'><p style='color:red; font-weight:bold;'>Agotado</p></div>";
                }
                else{
                    echo "<div class='divEditLibro'><p style='color:green; font-weight:bold;'>Disponible</p></div>";
                }
                ?>

                <!-- Precio -->
                <div class="divPrecioLibro">
                    <p><?php echo $row['precioUni']." €"?></p>
                </div>
                
                <?php 
                if($row['stock']!=0){
                    echo '<input type="text" value="1" id="cantidadLibroInput" min="1" max="'.$row['stock'].'" autofocus>';?>
                    <!-- Añadir a la cesta -->
                    <?php $isbn=$row['ISBN']; ?>
                    <div>
                        <?php $isbnString=strval($row['ISBN']); echo "<a id='enlaceLibroAnyadir' href='index.php?controller=libro&action=anyadirLibroCarrito&cantidad=1&isbn=$isbnString'>"; ?>
                            <div class="botonAñadir">
                                <img src="pic/cesta.png" alt="">
                                <p>AÑADIR A LA CESTA</p>
                            </div>
                        </a>
                    </div>
                    <script>
                            //Cambiar enlace en base a la cantidad
                            var stock = <?php echo json_encode($row['stock']); ?>;
                            var isbn = <?php echo json_encode($row['ISBN']); ?>;
                            var cantidadFinal = 1;
                            const enlaceLibroAnyadir = document.getElementById("enlaceLibroAnyadir");
                            const cantidad = document.getElementById("cantidadLibroInput").addEventListener('keyup',(e)=>{
                                cantidadFinal = e.target.value;
                                if(isNaN(parseInt(cantidadFinal)) || parseInt(cantidadFinal) < 1){
                                    cantidadFinal = 1;
                                }
                                if(parseInt(cantidadFinal) > stock){
                                    cantidadFinal = stock;
                                }
                                enlaceLibroAnyadir.href = 'index.php?controller=libro&action=anyadirLibroCarrito&isbn='+isbn+'&cantidad='+cantidadFinal;
                            });
                    </script>
                    <?php
                        if(isset($_GET["done"])){
                            ?><script>swal("","Producto añadido correctamente!","success",{buttons : ["ok"]})</script><?php
                        }
                }
                ?>
            </div>
    <?php 
    }
?>