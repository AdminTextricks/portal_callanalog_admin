#!/bin/bash

# File to store system information
output_file="/var/www/html/callanalog/admin/system_info.txt"

# Clear the previous content of the output file
> "$output_file"

# Get disk space
disk_space=$(df -h | grep /dev/md2)
echo "Disk Space:" >> "$output_file"
echo "$disk_space" >> "$output_file"
echo "" >> "$output_file"

# Get memory usage
memory_usage=$(free -h)
echo "Memory Usage:" >> "$output_file"
echo "$memory_usage" >> "$output_file"
echo "" >> "$output_file"

# Get timezone
timezone=$(timedatectl | grep 'Time zone')
echo "Timezone:" >> "$output_file"
echo "$timezone" >> "$output_file"
echo "" >> "$output_file"

# Get uptime
uptime=$(uptime)
echo "Uptime:" >> "$output_file"
echo "$uptime" >> "$output_file"
echo "" >> "$output_file"

# Get CPU usage
cpu_usage=$(top -bn1 | grep 'Cpu(s)')
echo "CPU Usage:" >> "$output_file"
echo "$cpu_usage" >> "$output_file"
echo "" >> "$output_file"

# Get bandwidth
bandwidth=$(sar -n DEV 1 1 | grep enp2s0f0 | grep -E '^(Average|em1)')
echo "Bandwidth:" >> "$output_file"
echo "$bandwidth" >> "$output_file"
echo "" >> "$output_file"

# Total bandwidth
bandwidth=$(vnstat | grep enp2s0f0)
echo "Total Bandwidth:" >> "$output_file"
echo "$bandwidth" >> "$output_file"
echo "" >> "$output_file"

echo "System information has been saved to $output_file"
