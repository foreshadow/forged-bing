<div class="row">
<div class="col-md-12">
<div class="panel panel-default" style="background-color: rgba(255, 255, 255, 0.9)">
  <table class="table">
    <tbody>
      <?php foreach (json_decode(file_get_contents('http://contests.acmicpc.info/contests.json')) as $contest): ?>
      <?php if ($contest->oj == 'Codeforces' || $contest->oj == 'Topcoder'): ?>
      <tr>
        <td style="padding-left: 15px; padding-right: 15px;">
          <a href="<?php echo $contest->link; ?>"><h5 style="margin-top: 0;"><?php echo substr($contest->name, 0, 30); ?></h5></a>
          <div>
            <p class="list-group-item-text pull-right">
              <?php echo date('n/j', strtotime($contest->start_time)); ?>
              <?php echo date('G:i', strtotime($contest->start_time)); ?>
            </p>
            <p class="list-group-item-text"><?php echo $contest->oj; ?></p>
          </div>
        </td>
      </tr>
      <?php endif; endforeach; ?>
    </tbody>
  </table>
  <div class="panel-footer">Online Contests</div>
</div>
</div>
</div>
