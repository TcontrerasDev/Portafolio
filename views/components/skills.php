<section id="habilidades" class="technical">
    <div class="container">
        <div class="row row-border row-technical">
            <div class="col-12 col-title">
                <h2 class="text-uppercase technical-title">Capacidades <span>Técnicas</span></h2>
            </div>
            <div class="col-12 mt-5">
                <div class="row">
                    <?php if (isset($error) && $error) { ?>

                        <div class="col-12">
                            <p class="alert alert-warning"><?php echo htmlspecialchars($error); ?></p>
                        </div>

                    <?php } elseif (empty($habilidades)) { ?>

                        <div class="col-12">
                            <p class="text-muted">No se encontraron habilidades registradas.</p>
                        </div>

                    <?php } else { ?>

                        <?php foreach ($habilidades as $categoria => $listaHabilidades) { ?>
                            <article class="col-12 col-md-6 col-lg-4 p-3">
                                <div class="skill-card">
                                    <h3 class="skill-card-title"><?php echo htmlspecialchars($categoria); ?></h3>
                                    <ul class="skill-list">
                                        <?php foreach ($listaHabilidades as $habilidad) { ?>
                                            <li class="skill-list-item"><?php echo htmlspecialchars($habilidad); ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </article>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>