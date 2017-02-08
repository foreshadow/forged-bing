<?php

function codeforces_rank_color_class($rating) {
    if ($rating >= 2900) {
        return 'user-legendary';
    } elseif ($rating >= 2600) {
        return 'user-red';
    } elseif ($rating >= 2400) {
        return 'user-red';
    } elseif ($rating >= 2200) {
        return 'user-orange';
    } elseif ($rating >= 1900) {
        return 'user-violet';
    } elseif ($rating >= 1600) {
        return 'user-blue';
    } elseif ($rating >= 1400) {
        return 'user-cyan';
    } elseif ($rating >= 1200) {
        return 'user-green';
    } else {
        return 'user-gray';
    }
}

function codeforces_verdict_class($verdict) {
    if (!isset($verdict)) {
        return 'verdict-waiting';
    } elseif ($verdict == 'SKIPPED') {
        return '';
    } elseif ($verdict == 'CHALLENGED') {
        return 'verdict-failed';
    } elseif ($verdict == 'OK') {
        return 'verdict-accepted';
    } else {
        return 'verdict-rejected';
    }
}

function codeforces_verdict($verdict, $testcase, $testset) {
    if (!isset($verdict)) {
        if ($testset == 'TESTS' && isset($testcase)) {
            return 'Testing on test ' . (string) ($testcase + 1);
        } else {
            return 'In queue';
        }
    } elseif ($verdict == 'CHALLENGED') {
        return 'Hacked';
    } elseif ($verdict == 'SKIPPED') {
        return 'Skipped';
    } else if ($verdict == 'OK') {
        if ($testset == 'PRETESTS') {
            return 'Pretest passed';
        } else {
            return 'Accepted';
        }
    } else {
        return ucwords(strtolower(str_replace('_', ' ', $verdict))) . ' on test ' . (string) ($testcase + 1);
    }
}

date_default_timezone_set('Asia/Shanghai');

$handle = $_GET['handle'];

$info = json_decode(file_get_contents("http://codeforces.com/api/user.info?handles=$handle"))->result[0];
$json = json_decode(file_get_contents('http://codeforces.com/api/contest.list'));
$status = json_decode(file_get_contents("http://codeforces.com/api/user.status?handle=$handle&from=1&count=10"))->result;
$rating = json_decode(file_get_contents('http://codeforces.com/api/user.rating?handle=Infinity25'))->result;
$last = $rating[count($rating) - 1];
$increment = $last->newRating - $last->oldRating;
$list = [];
foreach ($json->result as $contest) {
    if ($contest->phase == 'FINISHED') {
        break;
    }
    array_push($list, $contest);
}
$first = true; $new = 0;
?>
<link href="http://st.codeforces.com/s/81780/css/community.css" rel="stylesheet"></link>
<li class="dropdown-content" style="height: 80px;">
  <div style="width: 80px; height: 80px; float: left; overflow: hidden;
    background: url(http://userpic.codeforces.com/302499/title/249e4eb17611824f.jpg);
    background-position: center; background-size: cover; border-radius: 3px; "></div>
  <div style="float: left; margin-left: 15px; width: 233px;">
    <div class="<?php echo codeforces_rank_color_class($info->rating); ?>" style="margin: 0; font-weight: bold;">
      <div style="float: right;"><?php echo $info->rating; ?></div>
      <div><?php echo ucwords($info->rank); ?></div>
      <div style="float: right; font-size: 12px; color: #bbb;"><?php if ($increment > 0) { echo '+'; } echo $increment; ?></div>
    </div>
    <h3 class="rated-user <?php echo codeforces_rank_color_class($info->rating); ?>" style="margin: 0;">
      <?php echo $info->handle; ?>
    </h3>
    <p style="margin: 0; font-size: small; color: #777">
      <?php if ($info->firstName) echo "$info->firstName $info->lastName, "; ?>
      <a><?php echo $info->city; ?></a><?php if ($info->city && $info->country) echo ',&nbsp;'; ?><a><?php echo $info->country; ?></a>
    </p>
    <p style="margin: 0; font-size: small; color: #777">
      <?php if ($info->organization) echo "From <a>$info->organization</a>"; ?>
    </p>
  </div>
</li>
<li class="divider divider-black"></li>
<li class="dropdown-content" style="font-weight: bold;">Upcoming Contests</li>
<li class="divider"></li>
<?php foreach (array_reverse($list) as $contest): if (!$first) : ?>
<li class="divider"></div>
<?php endif; ?>
<li class="dropdown-content">
  <div>
    <span class="pull-right" style="margin: 0; line-height: 15px;">
      <?php echo date('n/j', $contest->startTimeSeconds); ?>
      <?php echo date('H:i', $contest->startTimeSeconds); ?>
    </span>
    <a href="http://codeforces.com/contests/<?php echo $contest->id; ?>" style="padding: 0;">
      <h5 class="inline" style="margin: 0;"><?php echo $contest->name; ?></h5>
    </a>
  </div>
</li>
<?php $first = false; $new++; endforeach; ?>
<li id="contest-new" class="hidden"><?php echo $new; ?></li>

<link href="http://st.codeforces.com/s/29632/css/status.css" rel="stylesheet"></link>
<li class="divider divider-black"></div>
<li class="dropdown-content" style="font-weight: bold;">Recent Status</li>
<?php $n = count($status); for ($i = 0; $i < $n; ): $s = $status[$i];?>
<li class="divider"></div>
<li class="dropdown-content">
  <p style="margin: 0; font-weight: bold;">
    <a href="http://codeforces.com/contest/<?php echo $s->problem->contestId; ?>/problem/<?php echo $s->problem->index; ?>">
      <?php echo $s->problem->contestId . $s->problem->index . ' - ' . $s->problem->name; ?>
    </a>
  </p>
  <!-- <p class="divider"></p> -->
  <?php do { ?>
  <p class="pull-right" style="margin: 0; font-size: small; color: #bbb;">
      <?php echo date('n/j H:i', $s->creationTimeSeconds); ?>
  </p>
  <p style="margin: 0;">
    <span class="<?php echo codeforces_verdict_class($s->verdict); ?> verdict"
          style="cursor: default;"
          title="<?php echo $s->timeConsumedMillis; ?> ms, <?php echo $s->memoryConsumedBytes / 1024; ?> KB">
      <?php echo codeforces_verdict($s->verdict, $s->passedTestCount, $s->testset); ?>
    </span>
    <a href="http://codeforces.com/contest/<?php echo $s->problem->contestId; ?>/submission/<?php echo $s->id; ?>"> #</a>
  </p>
  <p class="hidden" style="margin: 0;">
    <?php echo $s->timeConsumedMillis; ?> ms&nbsp;
    <?php echo $s->memoryConsumedBytes / 1024; ?> KB
  </p>
  <?php if (++$i < $n) { $pp = $s->problem; $s = $status[$i]; $cp = $s->problem; } ?>
  <?php } while ($i < $n && $pp->contestId . $pp->index == $cp->contestId . $cp->index); ?>
</li>
<?php endfor; ?>
