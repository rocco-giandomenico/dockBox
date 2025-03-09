FROM php:apache

# Variables
ARG USER_ID
ARG GROUP_ID
ARG UNAME
ARG DEBIAN_FRONTEND=noninteractive

# Copy Files
COPY bash-dockbox /etc

# Update and libraries
RUN apt-get update -q --fix-missing && \
    apt-get upgrade -y --no-install-recommends && \
    apt-get install -y --no-install-recommends \
        apt-utils \
        sudo \
        nano \
        wget \
        curl \
        git \
        zip \
        unzip \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libcurl4-openssl-dev \
        libsqlite3-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libmagickwand-dev \
        default-mysql-client \
        gnupg \
        lsb-release \
        unixodbc-dev && \

    # Aggiunta chiave Microsoft e repository
    curl -sSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft.gpg && \
    echo "deb [signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/$(lsb_release -rs)/prod $(lsb_release -cs) main" > /etc/apt/sources.list.d/mssql-release.list && \
    apt-get update -q --fix-missing && \
    ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools && \

    # Install PHP Extensions
    pecl install sqlsrv pdo_sqlsrv && \
    docker-php-ext-enable sqlsrv pdo_sqlsrv && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_sqlite \
        bcmath \
        mysqli \
        curl \
        zip \
        intl \
        mbstring \
        gettext \
        calendar \
        exif \
        gd && \
    pecl install imagick && \
    docker-php-ext-enable imagick && \
    \
    \
    # Create User and permissions
    groupadd -g ${GROUP_ID} ${UNAME} && \
    useradd -u ${USER_ID} -g ${UNAME} -m dockbox && \
    usermod -aG ${UNAME} www-data && \
    usermod -aG sudo ${UNAME} && \
    sudo usermod -aG sudo www-data && \
    echo "${UNAME} ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers.d/${UNAME} && \
    echo "www-data ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers.d/www-data && \
    chmod 440 /etc/sudoers.d/${UNAME} && \
    \
    \
    # Configure Apache
    a2enmod ssl rewrite headers vhost_alias && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    mkdir -p /etc/apache2/ssl && \
    \
    \
    # Install Node.js 22.x e yarn
    curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs && \
    npm install --global yarn && \
    npm install --global vite create-vite && \
    \
    \
    # Install Composer
    curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin \
        --filename=composer  && \
    \
    \
    # Oh My Bash
    bash -c "$(curl -fsSL https://raw.githubusercontent.com/ohmybash/oh-my-bash/master/tools/install.sh)" --prefix=/usr/local && \
    sed -i 's/OSH_THEME=.*/OSH_THEME="zork"/' /usr/local/share/oh-my-bash/bashrc && \
    echo '. /etc/bash-dockbox' >> /usr/local/share/oh-my-bash/bashrc && \
    cp /usr/local/share/oh-my-bash/bashrc ~/.bashrc && \ 
    cp /usr/local/share/oh-my-bash/bashrc /home/${UNAME}/.bashrc && \
    \
    \
    # Clean
    apt-get clean -y && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* /root/.cache/* /usr/src/*
    
# Workdir
WORKDIR /var/www/projects