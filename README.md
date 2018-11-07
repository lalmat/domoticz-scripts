# Domoticz Scripts

## Objectif

Le but de ce repository est de proposer un panel de scripts permettant facilement de lier des API tierces avec Domoticz.

D'une manière plus générale, il peut être utilisée pour miner de la donnée via les différents connecteurs d'API, les classes permettant d'abstraire l'intégration des API / Scrappers

## Configuration

Copiez le fichier domoticz.config.json.sample en domoticz.config.json

```json
{
  "domoticz": {
    "api": "http(s)://DOMOTICZ_URL:DOMOTICZ_PORT",
    "token": "base64(DOMOTICZ_USER:DOMOTICZ_PASS)",
    "scripts_idx": {
      "forecast": {
        "weather": "DOMOTICZ_WEATHER_IDX",
        "wind": "DOMOTICZ_WIND_IDX",
        "result": "DOMOTICZ_DUMMY_TEXT_IDX"
      }
    },
    "owm_city": "OPENWEATHERMAP_CITY_CODE"
  },
  "openWeatherMap": {
    "token": "OPENWEATHERMAP_TOKEN"
  },
  "db": {
    "dsn": "MYSQL_DSN",
    "user": "MYSQL_USER",
    "pass": "MYSQL_PASS"
  },
  "smtp": {
    "host": "SMTP_HOST",
    "port": "SMTP_PORT",
    "username": "SENDER_NAME",
    "usermail": "SENDER_EMAIL",
    "user": "SMTP_USER",
    "pass": "SMTP_PASSWORD"
  },
  "users": [
    {
      "firstname": "USER_FIRSTNAME",
      "lastname": "USER_LASTNAME",
      "birth": "BIRTH_DATE_ISO_FORMAT",
      "email": "USER_EMAIL",
      "owm_work": "USER_OPENWEATHERMAP_WORK_CITY"
    }
  ]
}
```

## Scripts

- Domoticz : Classe d'interconnexion avec Domoticz
- Forecast : Classe Météo permettant de récupérer facilement des données météo
- NewDay : Classe permettant d'envoyer un e-mail journalier de la journée.
- Calendar : Todo
- Horoscope : Todo
- MyEvents : Todo
