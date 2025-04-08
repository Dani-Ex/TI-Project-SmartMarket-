<div class="dashboard fullHeight">
    <!-- Dashboard content -->
    <div class="dashboardContent">
        <div class="d-flex flex-column g-2 container">
            <div class="row g-4">
                <div class="col-12">
                    
                    <div class='d-flex flex-column flex-lg-row justify-contents-center align-items-center' >
                        
                        
                        <div class='d-flex flex-column gap-3' >
                            <h1 class='heroTitle'>Welcome to <span class='text-warning'>Brainiversity</span>, your Intelligent Uni</h1>
                            
                            <p class='mainTextColor heroText fw-normal'>Brainiversity keeps you updated in real-time about campus happenings. Stay in the loop with our intelligent platform! </p>
                            <div>

                        
    <a class='heroButton btn btn-outline-warning' href="#bottomSection">Discover more</a>

                            </div>
                        </div>
                        <img src="../../img/hero.svg" class='heroImg' alt="hero image">
                    </div>

                    <form action="../../api/upload.php" method="post" enctype="multipart/form-data">
      Seleccione uma imagem para fazer upload (para a diretoria "api/images/"):
      <input type="file" name="imagem" />
      <input type="submit" value="Upload de Imagem" name="submit" />
    </form>
                    <?php echo "<img src='../../api/images/webcam.jpg?id=".time()."' style='width:100%'>"; ?>
                    <!-- Include sensor component -->
                    <?php include '../sensor/sensor.php';?>
                    <!-- Include atuador component -->
                    <?php include '../atuador/atuador.php';?>
                    
                    
                    <!-- Include creators component -->
                    <?php include '../creators/creators.php';?>
                </div>
            </div>
        </div>
    </div>
</div>