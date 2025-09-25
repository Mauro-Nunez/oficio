FROM alpine:3.18

RUN apk add --no-cache mariadb mariadb-client

RUN mkdir -p /run/mysqld /var/lib/mysql \
    && chown -R mysql:mysql /run/mysqld /var/lib/mysql

VOLUME /var/lib/mysql

COPY init.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/init.sh

EXPOSE 3306

USER mysql

ENTRYPOINT ["/usr/local/bin/init.sh"]