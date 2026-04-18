FROM mariadb:latest

ARG TIMEZONE="Europe/Madrid"

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

COPY my_database.sql /docker-entrypoint-initdb.d/

EXPOSE 3306