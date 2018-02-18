FROM maglnet/docker-zf2

# install composer
RUN  apt-get update \
  && apt-get install -y wget \
  && rm -rf /var/lib/apt/lists/*

RUN bash -c "wget http://getcomposer.org/composer.phar && mv composer.phar /usr/bin/composer"
RUN chmod 755 /usr/bin/composer

WORKDIR "/zf2-app"

ENTRYPOINT ["/assets/entrypoint.sh"]