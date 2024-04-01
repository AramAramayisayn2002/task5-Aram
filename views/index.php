<div class="content-header">
    <div class="container mt-1" style="width: 60%">
        <?php
        foreach ($data as $key => $value) {
            ?>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title mb-1"><?= ($data[$key]['title']); ?></h1>
                        <p class="card-text mb-3"><?= ($data[$key]['text']); ?></p>
                        <a href="<?= DOM ?>index/show?<?= ($data[$key]['id']); ?>" class="btn btn-success">Show</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="card">
                <div class="card-body flex justify-content-around">
                    <a href="<?= DOM ?>?page=<?= ($_SESSION['thisPage'] > 1) ? $_SESSION['thisPage'] - 1 : $_SESSION['thisPage']; ?>"
                       class="btn btn-dark">Previous</a>
                    <a href="<?= DOM ?>?page=<?= ($_SESSION['thisPage'] < $_SESSION['limitPage']) ? $_SESSION['thisPage'] + 1 : $_SESSION['thisPage']; ?>"
                       class="btn btn-success">Next</a>
                </div>
            </div>
        </div>
    </div>
</div>