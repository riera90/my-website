FROM ubuntu:18.04
# the timezone is set (if it is not set, a user prompt will be launched)
ENV TZ=Europe/Madrid
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
# the system (repo) is updated
RUN apt-get update
# PHP 7.2 is installed and some aditional packages
RUN apt-get install -y php7.2 php7.2-bcmath php7.2-cli php7.2-common php7.2-curl php7.2-gd php7.2-gmp \
php7.2-intl php7.2-json php7.2-mbstring php7.2-mysql php7.2-opcache php7.2-pgsql php7.2-phpdbg \
php7.2-readline php7.2-sqlite3 php7.2-xml php7.2-xmlrpc php7.2-zip php-xdebug
# Wget is installed (then it will be used fot composer installation)
RUN apt-get install wget unzip
# Composer in installed
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
# the files are added
COPY . /app
WORKDIR /app
RUN chmod +x ./init.sh
# First, composer install or updates the dependencies
# Then, the .env file is configured with sed and the variables
# Finally init.sh is launched
CMD ./init.sh