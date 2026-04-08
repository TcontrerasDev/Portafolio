 <section id="experiencia" class="experiencia container-fluid">
     <div class="container">
         <div class="row">
             <h2 class="text-uppercase experience-title">Experiencia</h2>
         </div>
         <div class="row justify-content-center gap-4 row-articles">
             <?php
                if (!empty($experience)) {
                    foreach ($experience as $exp) { ?>
                     <article class="col-12 col-lg-9 card-experiencia">
                         <div class="d-flex justify-content-between box-title">
                             <h3 class="title"><?php echo htmlspecialchars($exp['cargo']); ?></h3>
                             <p class="date"><?php echo htmlspecialchars($exp['periodo']); ?></p>
                         </div>
                         <p class="subtitle"><?php echo htmlspecialchars($exp['empresa']); ?></p>
                         <?php
                            $descripciones = explode("\n", $exp['descripcion']);
                            foreach ($descripciones as $parrafo) {
                                if (trim($parrafo) !== '') {
                                    echo '<p class="description mb-2">' . htmlspecialchars($parrafo) . '</p>';
                                }
                            }
                            ?>
                     </article>
             <?php }
                } ?>
         </div>
     </div>
 </section>