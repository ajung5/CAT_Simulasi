#!/usr/bin/env bash

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
LOG_FILE="$SCRIPT_DIR/storage/logs/php-server/latest.log"

if [ ! -e "$LOG_FILE" ]; then
    echo "Log PHP server belum ditemukan."
    echo "Jalankan ./run-local.sh terlebih dahulu."
    exit 1
fi

echo "========================================"
echo " CAT Simulasi Request Monitor"
echo "========================================"
echo "Log : $LOG_FILE"
echo ""
echo "Monitoring endpoint:"
echo "- soal-siswa"
echo "- get-soal"
echo "- simpanjawabankliksiswa"
echo "- kirimjawaban"
echo "- hasil-siswa"
echo "- countexamtime"
echo ""
echo "Tekan Ctrl+C untuk keluar."
echo "========================================"
echo ""

tail -f "$LOG_FILE" | \
awk '/soal-siswa|get-soal|simpanjawabankliksiswa|kirimjawaban|hasil-siswa|countexamtime/'