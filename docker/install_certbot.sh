apt-get install -y software-properties-common
add-apt-repository ppa:certbot/certbot
apt-get update
apt-get install -y python-certbot-nginx

certbot --nginx

certbot --nginx certonly

certbot renew --dry-run

