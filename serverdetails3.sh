#!/bin/bash

# Define server details
SERVER_IP="85.195.76.161"
SSH_PORT="18634"
SSH_KEY="/var/www/.ssh/85.195.76.161_opnsipusr_privatekey.pem"
SSH_USER="opnsipusr"

# SSH command with key authentication and custom port
SSH_CMD="ssh -i $SSH_KEY -p $SSH_PORT -o StrictHostKeyChecking=no $SSH_USER@$SERVER_IP"

# Fetch server details and store in a text file
{
    echo "Disk Space:"
    $SSH_CMD "df -h | grep /dev/md2"

    echo -e "\nMemory Usage:"
    $SSH_CMD "free -h"

    echo -e "\nTimezone:"
    $SSH_CMD "timedatectl | grep 'Time zone'"

    echo -e "\nUptime:"
    $SSH_CMD "uptime"

    echo -e "\nCPU Usage:"
    $SSH_CMD "top -bn1 | grep 'Cpu(s)'"

    echo -e "\nBandwidth:"
    $SSH_CMD "sar -n DEV 1 1 | grep enp2s0f0 | grep -E '^(Average|em1)'"

    echo -e "\nTotal Bandwidth:"
    $SSH_CMD "vnstat | grep enp2s0f0"

}
# > /var/www/html/callanalog/admin/system_info3.txt
