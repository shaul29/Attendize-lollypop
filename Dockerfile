# Base image with nginx, php-fpm and composer built on debian
FROM wyveo/nginx-php-fpm:php74 as base

# Fix the expired key for sury.org repository
RUN apt-get install -y --no-install-recommends gnupg && \
    apt-key adv --keyserver keyserver.ubuntu.com --recv-keys B188E2B695BD4743

# Update the expired key for nginx repository
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys ABF5BD827BD9BF62

# Update and install necessary packages
RUN apt-get update && apt-get install -y \
    wait-for-it \
    libxrender1

# Set up code
WORKDIR /usr/share/nginx/html
COPY . .

# Run composer, chmod files, setup laravel key
RUN ./scripts/setup

# The worker container runs the laravel queue in the background
FROM base as worker
CMD ["php", "artisan", "queue:work", "--daemon"]

# The web container runs the HTTP server and connects to all other services in the application stack
FROM base as web

# nginx config
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Self-signed SSL certificate for https support
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt -subj "/C=GB/ST=London/L=London/O=NA/CN=localhost" \
    && openssl dhparam -out /etc/ssl/certs/dhparam.pem 2048 \
    && mkdir /etc/nginx/snippets
COPY self-signed.conf /etc/nginx/snippets/self-signed.conf
COPY ssl-params.conf /etc/nginx/snippets/ssl-params.conf

# Ports to expose
EXPOSE 80
EXPOSE 443

# Starting nginx server
CMD ["/start.sh"]
