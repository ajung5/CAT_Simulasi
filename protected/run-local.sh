#!/usr/bin/env bash

HOST="127.0.0.1"
PORT="8000"

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
DOCROOT="$SCRIPT_DIR/.."

LOG_DIR="$SCRIPT_DIR/storage/logs/php-server"

mkdir -p "$LOG_DIR"

TIMESTAMP="$(date '+%Y-%m-%d_%H-%M-%S')"

LOG_FILE="$LOG_DIR/php-server_${TIMESTAMP}.log"
LATEST_LOG="$LOG_DIR/latest.log"

ln -sfn "$(basename "$LOG_FILE")" "$LATEST_LOG"

echo "========================================"
echo " CAT Simulasi Development Server"
echo "========================================"
echo "URL        : http://${HOST}:${PORT}"
echo "App folder : ${SCRIPT_DIR}"
echo "Docroot    : ${DOCROOT}"
echo "Log file   : ${LOG_FILE}"
echo "Latest log : ${LATEST_LOG}"
echo "========================================"
echo ""
echo "Tekan Ctrl+C untuk menghentikan server."
echo ""

cd "$SCRIPT_DIR" || exit 1

php -S "${HOST}:${PORT}" -t "${DOCROOT}" 2>&1 | tee -a "$LOG_FILE"