FROM php:8.2-apache
RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql
# Activer le vhost public/ si présent (Cas B). Si le fichier n'existe pas, commente cette ligne.
# COPY apache-vhost.conf /etc/apache2/sites-available/000-default.conf
