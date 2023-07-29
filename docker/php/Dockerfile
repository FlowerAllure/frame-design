FROM php:8.2.6-fpm

# 更新为国内镜像
RUN mv /etc/apt/sources.list /etc/apt/sources.list.bak \
    && echo 'deb http://mirrors.ustc.edu.cn/debian stable main contrib non-free' > /etc/apt/sources.list \
    && echo 'deb http://mirrors.ustc.edu.cn/debian stable-updates main contrib non-free' >> /etc/apt/sources.list \
    && echo 'deb http://mirrors.ustc.edu.cn/debian stable-proposed-updates main contrib non-free' >> /etc/apt/sources.list \
    && apt-get update

# 安装依赖包
RUN apt-get install -y zip unzip wget curl vim

# 安装`PICKLE`扩展包
RUN wget https://github.com/FriendsOfPHP/pickle/releases/latest/download/pickle.phar \
    && chmod +x pickle.phar \
    && mv pickle.phar /usr/local/bin/pickle

# 安装`Composer`依赖包
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

# 安装`xdebug, redis`扩展
RUN pickle install xdebug && pickle install redis

# 启用`xdebug, redis`扩展
RUN docker-php-ext-enable redis xdebug
