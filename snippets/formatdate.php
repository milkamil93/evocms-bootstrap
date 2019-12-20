<?php

if (!is_numeric($date)) {
   return $date;
}
 
$names = [ 1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' ];
$date = (new \DateTime())->setTimestamp($date);
$m = $date->format('n');
    
return $date->format('d ') . $names[$m] . $date->format(' Y');
