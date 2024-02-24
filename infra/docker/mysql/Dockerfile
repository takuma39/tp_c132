FROM mysql/mysql-server:8.0

ENV TZ=UTC

RUN mkdir -p /var/log/mysql && \
    chown -R mysql:mysql /var/log/mysql && \
    chmod 755 /var/log/mysql
