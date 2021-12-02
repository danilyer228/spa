<div class="container">
    <form action="/handler.php">
        <input type="hidden" name="url" value="/exit">
        <button class="btn btn-primary" type="submit">Exit(<?= getUser($_SESSION['user_id'])['username'] ?>)</button>
    </form>
    <div class="row content">
        <form action="/handler.php" class="form-inline">
            <input type="hidden" name="url" value="/addOperation">
            <input type="number" class="form-control" name="sum" placeholder="Сумма">
            <select class="form-control" name="status">
                <option value="income">Приход</option>
                <option value="outcome">Расход</option>
            </select>
            <input type="text" class="form-control" placeholder="Комментарий" name="description">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
        <hr>
        <h5>Последние 10 записей</h5>
        <?php
            require_once __DIR__ . '/../functions.php';
            $records = getLastTenOperations($_SESSION['user_id']);
        ?>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Сумма</th>
                <th scope="col">Тип</th>
                <th scope="col">Комментарий</th>
                <th scope="col"> Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($records as $record) { ?>
            <tr>
                <td><?= $record['id'] ?></td>
                <td><?= $record['sum'] ?></td>
                <td><?= ($record['status'] == 'income') ? "Приход" : "Расход" ?></td>
                <td><?= $record['description'] ?></td>
                <td>
                    <form action="/handler.php">
                        <input type="hidden" name="id" value="<?= $record['id'] ?>">
                        <input type="hidden" name="url" value="/deleteOperation">
                        <button class="btn btn-primary" type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <br><br>
        <div class="summary">
            <?php
                $summary = getSummary($_SESSION['user_id']);
            ?>
            <h5>Итого: <?= count($records) ?></h5>
            <h5><?= $summary['income'] ?> приход; <?= $summary['outcome'] ?> расход</h5>
        </div>

    </div>
</div>
