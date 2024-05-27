<?php include 'sprache.php'?>

<body>

<?php include 'nav.php'; ?>

    <div style="margin-top: 1%; text-align: center;">
        <h3>Hi <?php echo htmlspecialchars($_SESSION['vorname'] ?? ''); ?> , <?= $lang['welcome'] ?> </h3>
    </div>
    <div class="row" style="width: 100%; padding: 0.5%;">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <img src="images/operations.svg" class="card-img-top" alt="..." style="width:auto; height:250px;">
                <div class="card-body">
                    <h5 class="card-title"><?= $lang['operations_schul'] ?></h5>
                    <p class="card-text"><?= $lang['op_m_text'] ?></p>
                    <a href="opeinst.php" class="btn btn-orange"><?= $lang['beginner'] ?></a>
                    <a href="opefort.php" class="btn btn-orange"><?= $lang['advanced'] ?></a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <img src="images/controlling.svg" class="card-img-top" alt="..." style="width:auto; height:250px;">
                <div class="card-body">
                    <h5 class="card-title"><?= $lang['controlling_schul'] ?></h5>
                    <p class="card-text"><?= $lang['co_m_text'] ?></p>
                    <a href="coeinst.php" class="btn btn-orange"><?= $lang['beginner'] ?></a>
                    <a href="cofortg.php" class="btn btn-orange"><?= $lang['advanced'] ?></a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
