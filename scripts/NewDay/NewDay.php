<?php
namespace DZSCR\NewDay;

class NewDay {

  public static function getSaintMsg_FR() {
    $saint = static::getSaint('fr');
    if ($saint[1] == "") {
      $first = substr($saint[0],0,1);
      if ($first == "E" || $first == "A") return "l'".$saint[0];
      else return "la ".$saint[0];
    }
    else return "la Saint ".$saint[0];
  }

  public static function getSaint($lang) {
    $file = __DIR__."/saints_$lang.json";
    $saintAry = json_decode(file_get_contents($file), true);
    $month = date("m");
    $day   = date("j");
    return $saintAry[$month][$day-1];
  }

  public static function getFullDate_FR() {
    $days = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    return $days[date('w')]." ".date('j')." ".$months[date('n')-1]." ".date('Y');
  }

}