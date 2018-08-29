<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>

    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.min.css"">
    <link rel="stylesheet" type="text/css" href="/static/css/datatables.min.css"/>

    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/static/js/datatables.min.js"></script>

    <title>PGSS Admin - <?=$pageTitle?></title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">PGSS Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item <?php if ($page == 'home') echo 'active'?>">
                    <a class="nav-link" href="/">Home <?php if ($page == '<span class="sr-only">(current)</span>') echo 'active'?></a>

                <li class="nav-item <?php if ($page == 'solvegyms') echo 'active'?>">
                    <a class="nav-link" href="/solvegyms">Solve Gyms <?php if ($page == '<span class="sr-only">(current)</span>') echo 'active'?></a>

                <li class="nav-item <?php if ($page == 'solvepokemon') echo 'active'?>">
                    <a class="nav-link" href="/solvepokemon">Solve Pokemon <?php if ($page == '<span class="sr-only">(current)</span>') echo 'active'?></a>

                <li class="nav-item <?php if ($page == 'checkgyms') echo 'active'?>">
                    <a class="nav-link" href="/checkgyms">Check Gyms <?php if ($page == '<span class="sr-only">(current)</span>') echo 'active'?></a>

                <li class="nav-item <?php if ($page == 'checkpokemon') echo 'active'?>">
                    <a class="nav-link" href="/checkpokemon">Check Pokemon <?php if ($page == '<span class="sr-only">(current)</span>') echo 'active'?></a>

                <li class="nav-item <?php if ($page == 'devices') echo 'active'?>">
                    <a class="nav-link" href="/devices">Devices <?php if ($page == '<span class="sr-only">(current)</span>') echo 'active'?></a>

                <li class="nav-item <?php if ($page == 'logs') echo 'active'?>">
                    <a class="nav-link" href="/logs">Logs <?php if ($page == '<span class="sr-only">(current)</span>') echo 'active'?></a>

            </ul>
        </div>
    </nav>
