<?php

if (isset($_POST['name']) && isset($_POST['time'])) {
    $db = new SQLite3($_SERVER['DOCUMENT_ROOT'].'/data.db');
    $st = $db->prepare('INSERT INTO deadlines (name, uts) VALUES (?, ?)');
    $st->bindValue(1, $_POST['name'], SQLITE3_TEXT);
    $st->bindValue(2, strtotime($_POST['time']), SQLITE3_INTEGER);
    if ($st->execute()) {
        echo 'Create deadline succeeded';
    } else {
        echo $db->lastErrorMsg();
    }
    $db->close();
    die();
} elseif (isset($_POST['id'])) {
    $db = new SQLite3($_SERVER['DOCUMENT_ROOT'].'/data.db');
    $st = $db->prepare('DELETE FROM deadlines WHERE id = ?');
    $st->bindValue(1, $_POST['id'], SQLITE3_INTEGER);
    if ($st->execute()) {
        echo 'Remove deadline succeeded';
    } else {
        echo $db->lastErrorMsg();
    }
    $db->close();
    die();
}
?>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default" style="background-color: rgba(255, 255, 255, 0.9)">
        <div id="collapse" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading">
          <table class="panel-body table table-condensed">
            <tbody>
              <?php $db = new SQLite3($_SERVER['DOCUMENT_ROOT'].'/data.db'); ?>
              <?php $results = $db->query('SELECT * FROM deadlines ORDER BY uts'); ?>
              <?php while ($row = $results->fetchArray()) : ?>
              <tr>
                <td class="text-left" style="padding-left: 15px;"><?php echo $row['name']; ?></td>
                <td class="text-right"><?php echo date('n/d', $row['uts']); ?></td>
                <td class="text-right" style="padding-right: 15px;">
                  <button id="<?php echo $row['id']; ?>" class="close deadline-remove" style="float: none;">&times;</button>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
        <!--                  disabled, remove this to enable                 vvvvvvvvv -->
        <div class="panel-footer" role="tab" id="footer" data-toggle="collapse-disabled" href="#collapse" aria-expanded="true" aria-controls="collapse">
          Todo list<button class="close" data-toggle="modal" data-target="#modal">&plus;</button>
        </div>
      </div>
    </div>
  </div>
