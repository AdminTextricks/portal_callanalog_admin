# Define variables
SOURCE_FILE="/var/www/html/callanalog/admin/webrtc_template.conf"
DESTINATION_SERVER="139.84.170.210"
DESTINATION_PORT="18634"  # Change to the actual SSH port of the destination server
DESTINATION_DIRECTORY="/etc/asterisk/webrtc_template.conf"  # Change to the desired directory on the destination server
SSH_PRIVATE_KEY="/var/www/.ssh/id_rsa"
SUDO_USER="astersecndusr"

# Transfer file using scp with key-based authentication and sudo
sudo scp -i "$SSH_PRIVATE_KEY" -P "$DESTINATION_PORT" "$SOURCE_FILE" "$SUDO_USER@$DESTINATION_SERVER:$DESTINATION_DIRECTORY"

# Check if the transfer was successful
if [ $? -eq 0 ]; then
    echo "File transfer successful."
else
    echo "File transfer failed."
fi
