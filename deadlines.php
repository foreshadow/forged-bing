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
<li style="margin: 6px 15px; text-decoration: underline; cursor: pointer;"
data-toggle="modal" data-target="#modal">
  <span class="text-primary">New deadline</span>
  <button class="close">&plus;</button>
  <span class="pull-right">Today <?php echo date('n/d'); ?>&nbsp;&nbsp;&nbsp;</span>
</li>
<?php $db = new SQLite3($_SERVER['DOCUMENT_ROOT'].'/data.db'); ?>
<?php $results = $db->query('SELECT * FROM deadlines ORDER BY uts'); ?>
<?php $new = 0; while ($row = $results->fetchArray()) : ?>
    <li class="divider"></li>
<li style="margin: 6px 15px;">
  <?php echo $row['name']; ?>
  <div class="pull-right">
    <?php echo date('n/d', $row['uts']); ?>&nbsp;&nbsp;
    <button id="<?php echo $row['id']; ?>" class="close deadline-remove" style="float: none;">&times;</button>
  </div>
</li>
<?php $new += 1; endwhile; ?>
<li id="deadlines-new" class="hidden"><?php echo $new; ?></li>
