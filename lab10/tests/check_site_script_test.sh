#!/usr/bin/env bash
set -euo pipefail

repo_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"

bash "$repo_root/lab10/check_site.sh" \
  "https://brzozsrpi.eastus.cloudapp.azure.com/iit" \
  "https://brzozsrpi.eastus.cloudapp.azure.com"
