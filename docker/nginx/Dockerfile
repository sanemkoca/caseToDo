FROM nginx:latest
RUN usermod -u 1000 www-data
ADD nginx.conf /etc/nginx/conf.d/default.conf
RUN apt-get update
RUN apt-get install openssl -y