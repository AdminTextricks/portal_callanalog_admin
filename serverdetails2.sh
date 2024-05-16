#!/bin/bash

# Define server details
SERVER_IP="37.61.219.110"
SSH_PORT="19645"
SSH_KEY="/var/www/.ssh/37.61.219.110_asteruser_privkey.pem"
SSH_USER="asteruser"

# SSH command with key authentication and custom port
SSH_CMD="ssh -i $SSH_KEY -p $SSH_PORT -o StrictHostKeyChecking=no $SSH_USER@$SERVER_IP"

# Fetch server details and store in a text file
{
    echo "Disk Space:"
    $SSH_CMD "df -h | grep /dev/md126"

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
#> /var/www/html/callanalog/admin/system_info2.txt
