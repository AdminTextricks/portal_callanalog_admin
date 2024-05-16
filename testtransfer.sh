#!/bin/bash

# Define variables
SOURCE_FILE="/var/www/html/callanalog/admin/portal_carrier.conf"
DESTINATION_SERVER="37.61.219.110"
DESTINATION_PORT="19645"  # Change to the actual SSH port of the destination server
DESTINATION_DIRECTORY="/etc/asterisk/portal_carrier.conf"  # Change to the desired directory on the destination server
SSH_PRIVATE_KEY="/var/www/.ssh/id_rsa"
SUDO_USER="asteruser"

# Transfer file using scp with key-based authentication and sudo
sudo scp -i "$SSH_PRIVATE_KEY" -P "$DESTINATION_PORT" "$SOURCE_FILE" "$SUDO_USER@$DESTINATION_SERVER:$DESTINATION_DIRECTORY"

# Check if the transfer was successful
if [ $? -eq 0 ]; then
    echo "File transfer successful."
else
    echo "File transfer failed."
fi

# Define variables
SOURCE_FILE="/var/www/html/callanalog/admin/portal_carrier.conf"
DESTINATION_SERVER="85.195.76.161"
DESTINATION_PORT="17342"  # Change to the actual SSH port of the destination server
DESTINATION_DIRECTORY="/etc/asterisk/portal_carrier.conf"  # Change to the desired directory on the destination server
SSH_PRIVATE_KEY="/var/www/.ssh/id_rsa"
SUDO_USER="opnsipusr"

# Transfer file using scp with key-based authentication and sudo
sudo scp -i "$SSH_PRIVATE_KEY" -P "$DESTINATION_PORT" "$SOURCE_FILE" "$SUDO_USER@$DESTINATION_SERVER:$DESTINATION_DIRECTORY"

# Check if the transfer was successful
if [ $? -eq 0 ]; then
    echo "File successful."
else
    echo "File  failed."
fi
