<footer id="footer">
        <div id="social-container">
            <li><a href="https://github.com/GuilhermeSchuch" target="_blanck"><i class="fab fa-github"></i></a></li>
            <li><a href="https://www.instagram.com/guigui.schuch/" target="_blanck"><i class="fab fa-instagram"></i></a></li>
            <li><a href="https://www.linkedin.com/in/guilhermeschuch2005/" target="_blanck"><i class="fab fa-linkedin"></i></a></li>
        </div>

        <div id="footer-links-container">
            <?php if($userData): ?>
                <ul>
                    <li><a href="<?= $BASE_URL ?>newmovie.php">Add movie</a></li>
                    <li><a href="<?= $BASE_URL ?>dashboard.php">My Movies</a></li>
                    <li><a href="<?= $BASE_URL ?>logout.php">Logout</a></li>
                </ul>
            <?php endif; ?>
        </div>

        <?php $url = $_SERVER['REQUEST_URI']; if (strpos($url, 'movie') !== false): ?>
            <div> Age Limit Icons made by <a href="https://www.flaticon.com/authors/tanah-basah" title="Tanah Basah"> Tanah Basah </a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com'</a></div>
        <?php endif ?>

        <p>&copy 2022 Guilherme Schuch</p>
    </footer>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.js" integrity="sha512-KCgUnRzizZDFYoNEYmnqlo0PRE6rQkek9dE/oyIiCExStQ72O7GwIFfmPdkzk4OvZ/sbHKSLVeR4Gl3s7s679g==" crossorigin="anonymous"></script>

    <!-- CUSTOM JS -->
    <script src="js\capsLock.js"></script>
    <script src="js\paste.js"></script>
    <script src="js\msgFadeOut.js"></script>
    <script src="js\automaticScroll.js"></script>
</body>
</html>