FROM        gauravnagar/php-7.3.11-apache

ENV APP_ENV="prod"

VOLUME      ["/app/uploads"]

COPY        .   /app


RUN         chmod -R 777 /app/uploads
run it 
