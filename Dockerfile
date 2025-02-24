# Usa l'immagine PHP con Apache
FROM php:8.1-apache

# Installa le dipendenze necessarie
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql


# Abilita mod_rewrite per Apache
RUN a2enmod rewrite

# Copia il codice del sito nella cartella di Apache
COPY . /var/www/html/

# Imposta i permessi giusti per i file
RUN chown -R www-data:www-data /var/www/html

# Espone la porta 80 per il server web
EXPOSE 80

# Avvia Apache in modalità foreground
CMD ["apache2-foreground"]