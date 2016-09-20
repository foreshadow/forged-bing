<?php

function li($url, $name) {
    return <<<HTML
    <li class=""><a href="$url"><img src="$url/favicon.ico" style="height: 20px;"> $name</a></li>
HTML;
}
function di() {
    return '<li class="divider"></li>';
}
echo li('//bilibili.com', 'Bilibili');
echo li('//taobao.com', 'Taobao');
echo li('//vjudge.net', 'Virtual Judge');
echo li('//codeforces.com', 'CodeForces');
echo li('//infinitys.site', 'Infinity\'s');
echo di();
echo li('//v3.bootcss.com', 'Bootstrap');
echo li('//atom.io', 'Atom');
