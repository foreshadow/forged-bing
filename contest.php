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
    if ($verdict == 'OK') {
        return "verdict-accepted";
    } else {
        return "verdict-rejected";
    }
}

function codeforces_verdict($verdict, $testcase) {
    if ($verdict == 'OK') {
        return "Accepted";
    } else {
        return ucwords(strtolower(str_replace('_', ' ', $verdict))) . ' on test ' . (string) ($testcase + 1);
    }
}

date_default_timezone_set('Asia/Shanghai');

$handle = $_GET['handle'];

$info = json_decode(file_get_contents("http://codeforces.com/api/user.info?handles=$handle"))->result[0];
$json = json_decode(file_get_contents('http://codeforces.com/api/contest.list'));
$status = json_decode(file_get_contents("http://codeforces.com/api/user.status?handle=$handle&from=1&count=10"))->result;
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
  <img src="<?php echo $info->titlePhoto; ?>"
       style="max-width: 90px; max-height: 80px; border-radius: 3px; float: left;">
  <div style="float: left; margin-left: 15px;">
    <p style="margin: 0;">
      <span class="<?php echo codeforces_rank_color_class($info->rating); ?>" style="font-weight: bold;">
        <?php echo ucwords($info->rank); ?> - <?php echo $info->rating; ?>
      </span>
    </p>
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
      <?php echo date('G:i', $contest->startTimeSeconds); ?>
    </span>
    <a href="http://codeforces.com/contests/<?php echo $contest->id; ?>" style="padding: 0;">
      <h5 style="margin: 0;"><?php echo substr($contest->name, 0, 32); ?></h5>
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
      <?php echo date('n/j G:i', $s->creationTimeSeconds); ?>
  </p>
  <p style="margin: 0;">
    <span class="<?php echo codeforces_verdict_class($s->verdict); ?> verdict"
          style="cursor: default;"
          title="<?php echo $s->timeConsumedMillis; ?> ms, <?php echo $s->memoryConsumedBytes / 1024; ?> KB">
      <?php echo codeforces_verdict($s->verdict, $s->passedTestCount); ?>
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
