<?php date_default_timezone_set('Asia/Shanghai'); ?>
<?php $url = 'http://codeforces.com/api/contest.list'; ?>
<?php $json = json_decode(file_get_contents($url)); ?>
<?php $first = true; $new = 0; foreach ($json->result as $contest): ?>
<?php if ($contest->phase == 'FINISHED') break; ?>
<?php if (!$first) : ?>
<li class="divider" style=""></div>
<?php endif; ?>
<li style="margin: 6px 15px;">
  <div>
    <span class="pull-right" style="margin: 0; line-height: 15px;">
      <?php echo date('n/j', $contest->startTimeSeconds); ?>
      <?php echo date('G:i', $contest->startTimeSeconds); ?>
    </span>
    <a href="//codeforces.com/contests/<?php echo $contest->id; ?>" style="padding: 0;">
      <h5 style="margin: 0;"><?php echo substr($contest->name, 0, 30); ?></h5>
    </a>
  </div>
</li>
<?php $first = false; $new += 1; endforeach; ?>
<li id="contest-new" class="hidden"><?php echo $new; ?></li>
