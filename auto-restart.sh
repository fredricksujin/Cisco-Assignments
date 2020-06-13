for I in 0 1 2 3 4 5; do
    check=$(uptime | tr -d ',.' | awk '{print $10}')
    if [ "$check" -gt 5 ]; then
        /usr/bin/systemctl restart httpd.service
    fi
    sleep 10
done