<?php
header('Cache-Control: max-age=1');
header('Etag: 1');
sleep(1);
echo  microtime(true);
