# Google Wallet Pass Generator

This project is a simple web application that allows you to create a Google Wallet Pass and store it in the Google Wallet app. The application uses the Google Wallet API and PHP for backend logic.

## Prerequisites

- **Docker** (Installed)
- **Docker Compose** (Installed)
- **Google Cloud Account** with Google Wallet API enabled
- **Google Wallet API credentials** (client_email and private_key)

## Installation

### 1. Clone the project

Clone the repository:

```bash
git clone https://github.com/your-username/your-repository.git
cd your-repository
```

### 2. Configure Google Wallet API credentials

Create a file named `walletconfig.json` in the `config/` directory. Use the `walletconfig.json_example` file as a template:

```bash
cp config/walletconfig.json_example config/walletconfig.json
```

Add your Google Wallet API credentials to the `walletconfig.json` file:

```json
{
  "type": "",
  "project_id": "",
  "private_key_id": "",
  "private_key": "",
  "client_email": "",
  "client_id": "",
  "auth_uri": "",
  "token_uri": "",
  "auth_provider_x509_cert_url": "",
  "client_x509_cert_url": "",
  "universe_domain": "googleapis.com"
}
```

Make sure that the `walletconfig.json` file is not uploaded to the repository by using the `.gitignore` file.

You must add your `issuerId` in **wallet.php** at line 11 (`private $issuerId = '';`). The `issuerId` is required to create Google Wallet objects and should be obtained from your Google Wallet API configuration.

### 3. Use Docker

This project includes a `docker-compose.yml` file that sets up the web server using the `php:apache` image.

#### 3.1 Start the Docker container

Run the following command to start the container:

```bash
docker-compose up -d && docker-compose logs -f
```

#### 3.2 Access the application

Once the container is running, you can access the application in your web browser at `http://localhost:8080`.

### 4. Install Composer dependencies

Once the container is running, you can install Composer dependencies inside the container:

```bash
docker exec -it <container_name> bash
composer install
```

Replace `<container_name>` with the name of the running container (you can find it with `docker ps`).

## Project Structure

- **index.html**: Frontend that provides the Google Wallet button and form.
- **wallet.php**: Backend logic that handles the creation of the Google Wallet pass.
- **config/walletconfig.json**: Configuration file for Google Wallet API credentials.
- **composer.json**: Contains project dependencies.
- **docker-compose.yml**: Docker configuration file to host the application in a container.

## Important Notes

- The `config/walletconfig.json` file contains sensitive data. Make sure this file is never uploaded to a public repository.
- The application is currently set up for testing with a hardcoded account number (`accountNumber`) and default values for first and last names.

## License

This project is licensed under the MIT License.

### Example `docker-compose.yml`

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
