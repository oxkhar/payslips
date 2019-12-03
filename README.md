# Payslips Pro

## Install the Application

Run this command from the directory of application.

```bash
composer install
```

To run the application in development, you can run these commands 

```bash
composer start
```

Or you can use `docker-compose` to run the app with `docker`, so you can run these commands:
```bash
docker-compose up -d
```

After that, ypu can test the API in `http://localhost:8080/payslips` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```

