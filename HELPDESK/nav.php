<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
        App Help Desk
    </a>

    <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) { ?>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">SAIR</a>
            </li>
        </ul>
    <?php } ?>

</nav>