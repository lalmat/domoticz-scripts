<?php
namespace DZSCR\Forecast;

class Forecast {

  public static function get_season() {
    $d = date('md');
    if ( ($d>='0320') & ($d<'0621') ) return 0; # Printemps
    if ( ($d>='0621') & ($d<'0923') ) return 1; # Ete
    if ( ($d>='0923') & ($d<'1221') ) return 2; # Automne
    return 3; # Hiver
  }

  public static function get_wind_cadran($wind_direction) {
    if ( ($wind_direction>=335) || ($wind_direction<=25)  ) return 0; # Nord
    if ( ($wind_direction>25)   && ($wind_direction<=110) ) return 1; # Est / Nord-Est
    if ( ($wind_direction>110)  && ($wind_direction<=200) ) return 2; # Sud / Sud-Est
    if ( ($wind_direction>200)  && ($wind_direction<=260) ) return 3; # Sud-Ouest
    return 4; # Ouest / Nord-Ouest
  }

  public static function get_hygro_section($hygro_hPa) {
    if ($hygro_hPa>=1020) return 0;
    if (($hygro_hPa>=1013) & ($hygro_hPa<1020)) return 1;
    if (($hygro_hPa>=1006) & ($hygro_hPa<1013)) return 2;
    else return 3;
  }
  
  public static function get_forecast($lang, $wind_direction, $hygro_hPa, $season=null) {
  
    $file = __DIR__."/forecast_".$lang.".json";
    $f = json_decode(file_get_contents($file),true);
    $s = ($season == null) ? static::get_season() : $season;
    $w = static::get_wind_cadran($wind_direction);
    $h = static::get_hygro_section($hygro_hPa);

    return $f[$lang][$s][$w][$h];
  }

}