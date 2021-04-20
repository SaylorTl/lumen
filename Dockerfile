FROM r.iamzx.cn:3443/sqy/nginx-php:v1.9

COPY nginx.conf /usr/local/nginx/conf.d/nginx.conf

COPY src /data/src

RUN chown -R www-data.www-data /data/src/ && chmod -R 755 /data/src

WORKDIR /data/src

EXPOSE 80

CMD sh -c 'chown -R www-data.www-data /data/src/storage/logs && nginx && php-fpm'
