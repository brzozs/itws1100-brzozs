# Lab 10 Deployment Notes

## FQDN
- https://brzozsrpi.eastus.cloudapp.azure.com

## GitHub Repository
- https://github.com/brzozs/itws1100-brzozs

## Files in this folder
- index.php: Sends a 302 redirect from the server root to /iit/.
- .htaccess.original: Backup of the original root auth configuration.
- deploy.php.example: Webhook handler template for auto-deploy (copy to /var/www/html/deploy.php on the server).
