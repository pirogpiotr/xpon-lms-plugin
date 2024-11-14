# Wtyczka XponLms dla LMS

## Instalacja

1. Skopiować katalog XponLms do katalogu z pluginami LMS.
1. Zainstalować bibliotekę httpful uruchamiając w katalogu z LMS polecenie:

        composer require nategood/httpful

1. Ustawić w konfiguracji LMS w sekcji xpon następujące opcje:
    - api_url - url prowadzący do Xpon API np. http://1.2.3.4/xpon/api/v1/
    - api_login i api_password z danymi użytkownika Xpon

