<?php $url = 'http://contests.acmicpc.info/contests.json'; ?>
<?php $json = json_decode(file_get_contents($url)); ?>
<?php $first = true; $new = 0; foreach ($json as $contest): ?>
<?php if ($contest->oj == 'Codeforces'): ?>
<?php if (!$first) : ?>
<li class="divider" style=""></div>
<?php endif; ?>
<li style="margin: 6px 15px;">
  <div>
    <span class="pull-right" style="margin: 0; line-height: 15px;">
      <?php echo date('n/j', strtotime($contest->start_time)); ?>
      <?php echo date('G:i', strtotime($contest->start_time)); ?>
    </span>
    <a href="<?php echo $contest->link; ?>" style="padding: 0;">
      <h5 style="margin: 0;"><?php echo substr($contest->name, 0, 30); ?></h5>
    </a>
  </div>
</li>
<?php $first = false; $new += 1; endif; endforeach; ?>
<li id="contest-new" class="hidden"><?php echo $new; ?></li>
