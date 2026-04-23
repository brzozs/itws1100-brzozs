#!/usr/bin/env bash
set -euo pipefail

FQDN="${FQDN:-brzozsrpi.eastus.cloudapp.azure.com}"
EMAIL="${1:-${CERTBOT_EMAIL:-}}"

if [[ -z "$EMAIL" ]]; then
  echo "Usage: sudo FQDN=your-host.example.com $0 you@example.com"
  exit 1
fi

if [[ "${EUID}" -ne 0 ]]; then
  echo "Run this script with sudo so Apache and Certbot can be configured."
  exit 1
fi

export DEBIAN_FRONTEND=noninteractive

apt-get update
apt-get install -y certbot python3-certbot-apache

a2enmod ssl rewrite headers >/dev/null

if command -v ufw >/dev/null 2>&1; then
  ufw allow 'Apache Full' || true
fi

certbot \
  --apache \
  --non-interactive \
  --agree-tos \
  --redirect \
  --email "$EMAIL" \
  --domains "$FQDN"

systemctl reload apache2

echo "HTTPS is configured for https://$FQDN/"
