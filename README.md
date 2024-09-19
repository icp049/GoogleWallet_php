# Google Wallet Pass Generator

Dieses Projekt ist eine einfache Webanwendung, die es ermöglicht, einen Google Wallet Pass zu erstellen und in der Google Wallet App zu speichern. Die Anwendung nutzt die Google Wallet API und verwendet PHP für die Backend-Logik.

## Voraussetzungen

- **Docker** (Installiert)
- **Docker Compose** (Installiert)
- **Google Cloud Account** mit aktiviertem Google Wallet API
- **Google Wallet API Zugangsdaten** (client_email und private_key)

## Installation

### 1. Projekt klonen

Klonen Sie das Repository:

```bash
git clone https://github.com/dein-username/dein-repository.git
cd dein-repository
```

### 2. Google Wallet API Zugangsdaten konfigurieren

Erstellen Sie im Verzeichnis `config/` eine Datei namens `walletconfig.json`. Nutzen Sie dafür die Datei `walletconfig.json_example` als Vorlage:

```bash
cp config/walletconfig.json_example config/walletconfig.json
```

Fügen Sie Ihre Google Wallet API-Zugangsdaten in die Datei `walletconfig.json` ein:

```json
{
  "client_email": "YOUR_CLIENT_EMAIL",
  "private_key": "YOUR_PRIVATE_KEY"
}
```

Stellen Sie sicher, dass die Datei `walletconfig.json` nicht in das Repository hochgeladen wird, indem Sie die `.gitignore`-Datei verwenden.

### 3. Docker verwenden

Dieses Projekt enthält eine `docker-compose.yml`-Datei, die den Webserver mit dem `php:apache`-Image bereitstellt.

#### 3.1 Docker-Container starten

Führen Sie folgenden Befehl aus, um den Container zu starten:

```bash
docker-compose up -d && docker-compose logs -f
```

#### 3.2 Zugriff auf die Anwendung

Sobald der Container läuft, können Sie die Anwendung in Ihrem Webbrowser unter `http://localhost:8080` aufrufen.

### 4. Composer-Abhängigkeiten installieren

Sobald der Container läuft, können Sie Composer-Abhängigkeiten im Container installieren:

```bash
docker exec -it <container_name> bash
composer install
```

Ersetzen Sie `<container_name>` durch den Namen des laufenden Containers (Sie können ihn mit `docker ps` finden).

## Struktur des Projekts

- **index.html**: Frontend, das den Google Wallet Button und das Formular bereitstellt.
- **wallet.php**: Backend-Logik, die die Erstellung des Google Wallet Passes handhabt.
- **config/walletconfig.json**: Konfigurationsdatei für die Google Wallet API-Zugangsdaten.
- **composer.json**: Enthält die Projektabhängigkeiten.
- **docker-compose.yml**: Docker-Konfigurationsdatei, um die Anwendung in einem Container zu hosten.

## Wichtige Hinweise

- Die Datei `config/walletconfig.json` enthält sensible Daten. Stellen Sie sicher, dass diese Datei niemals in ein öffentliches Repository hochgeladen wird.
- Die Anwendung ist aktuell auf das Testen mit einem hartkodierten Kontonummer (`accountNumber`) und Standardwerten für Vor- und Nachnamen ausgelegt.

## Lizenz

Dieses Projekt steht unter der MIT-Lizenz.
```

### Beispiel `docker-compose.yml`

```yaml
version: '3.8'

services:
  web:
    image: php:8.1-apache
    container_name: wallet-web
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html/
    restart: always
```