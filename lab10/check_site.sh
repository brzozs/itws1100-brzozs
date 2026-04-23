#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${1:-http://brzozsrpi.eastus.cloudapp.azure.com/iit}"
SECURE_BASE="${2:-https://brzozsrpi.eastus.cloudapp.azure.com}"

failures=0

check_status() {
  local label="$1"
  local expected="$2"
  local url="$3"
  local extra_args=()
  local actual

  if [[ "$#" -gt 3 ]]; then
    extra_args=("${@:4}")
  fi

  if [[ "${#extra_args[@]}" -gt 0 ]]; then
    actual="$(curl -sS -o /dev/null -w '%{http_code}' "${extra_args[@]}" "$url" || true)"
  else
    actual="$(curl -sS -o /dev/null -w '%{http_code}' "$url" || true)"
  fi

  if [[ "$actual" == "$expected" ]]; then
    echo "[PASS] $label -> $actual"
  else
    echo "[FAIL] $label -> expected $expected, got $actual"
    failures=$((failures + 1))
  fi
}

check_status "Lab 2 redirect" "302" "$BASE_URL/labs/open.php?item=lab02"
check_status "Lab 2 public page" "200" "$BASE_URL/labs/open.php?item=lab02" -L
check_status "Lab 4 landing page" "200" "$BASE_URL/labs/open.php?item=lab04" -L
check_status "Lab 1 auth challenge" "401" "$BASE_URL/labs/open.php?item=lab01" -L
check_status "Lab 9 auth challenge" "401" "$BASE_URL/labs/open.php?item=lab09" -L
check_status "HTTPS root" "200" "$SECURE_BASE/" -k -L

if [[ "$failures" -gt 0 ]]; then
  echo
  echo "$failures check(s) failed."
  exit 1
fi

echo
echo "All checks passed."
