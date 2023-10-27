ARG PHP_EXTENSIONS="mysqli pgsql pdo_mysql pdo_pgsql"

FROM thecodingmachine/php:8.1-v4-apache-node18
WORKDIR /workspace

USER root

RUN apt-get update \
    && apt-get install -y mysql-client


ARG ENABLE_NONROOT_DOCKER="true"
ARG USE_MOBY="false"
ARG USERNAME=automatic
ARG USER_UID=1000
ARG USER_GID=$USER_UID
RUN curl -o- https://raw.githubusercontent.com/microsoft/vscode-dev-containers/main/script-library/docker-debian.sh | bash - "${ENABLE_NONROOT_DOCKER}" "/var/run/docker-host.sock" "/var/run/docker.sock" "${USERNAME}"

ENTRYPOINT [ "/usr/local/share/docker-init.sh" ]
CMD [ "sleep", "infinity" ]


# # https://github.com/microsoft/vscode-dev-containers/blob/main/containers/docker-from-docker-compose/.devcontainer/Dockerfile
# COPY .devcontainer/*.sh /tmp/library-scripts/
# RUN apt-get update \
#     # && /bin/bash /tmp/library-scripts/common-debian.sh "${INSTALL_ZSH}" "${USERNAME}" "${USER_UID}" "${USER_GID}" "${UPGRADE_PACKAGES}" "true" "true" \
#     # Use Docker script from script library to set things up
#     && /bin/bash /tmp/library-scripts/docker-debian.sh "${ENABLE_NONROOT_DOCKER}" "/var/run/docker-host.sock" "/var/run/docker.sock" "${USERNAME}" \
#     # Clean up
#     && apt-get autoremove -y && apt-get clean -y && rm -rf /var/lib/apt/lists/* /tmp/library-scripts/


# # # Install Docker CE CLI
# # RUN apt-get update \
# #     && apt-get install -y apt-transport-https ca-certificates curl gnupg2 lsb-release \
# #     && curl -fsSL https://download.docker.com/linux/$(lsb_release -is | tr '[:upper:]' '[:lower:]')/gpg | apt-key add - 2>/dev/null \
# #     && echo "deb [arch=$(dpkg --print-architecture)] https://download.docker.com/linux/$(lsb_release -is | tr '[:upper:]' '[:lower:]') $(lsb_release -cs) stable" | tee /etc/apt/sources.list.d/docker.list \
# #     && apt-get update \
# #     && apt-get install -y docker-ce-cli

# # # Install Docker Compose
# # RUN export LATEST_COMPOSE_VERSION=$(curl -sSL "https://api.github.com/repos/docker/compose/releases/latest" | grep -o -P '(?<="tag_name": ").+(?=")') \
# #     && curl -sSL "https://github.com/docker/compose/releases/download/${LATEST_COMPOSE_VERSION}/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose \
# #     && chmod +x /usr/local/bin/docker-compose

# # # Enable non-root access to Docker
# # ARG NONROOT_USER=vscode

# # RUN echo -e "#!/bin/sh\n\
# #     sudoIf() { if [ \"\$(id -u)\" -ne 0 ]; then sudo \"\$@\"; else \"\$@\"; fi }\n\
# #     SOCKET_GID=\$(stat -c '%g' /var/run/docker.sock) \n\
# #     if [ \"${SOCKET_GID}\" != '0' ]; then\n\
# #         if [ \"\$(cat /etc/group | grep :\${SOCKET_GID}:)\" = '' ]; then sudoIf groupadd --gid \${SOCKET_GID} docker-host; fi \n\
# #         if [ \"\$(id ${NONROOT_USER} | grep -E \"groups=.*(=|,)\${SOCKET_GID}\(\")\" = '' ]; then sudoIf usermod -aG \${SOCKET_GID} ${NONROOT_USER}; fi\n\
# #     fi\n\
# #     exec \"\$@\"" > /usr/local/share/docker-init.sh \
# #     && chmod +x /usr/local/share/docker-init.sh

# # Setting the ENTRYPOINT to docker-init.sh will configure non-root access 
# # to the Docker socket. The script will also execute CMD as needed.
# ENTRYPOINT [ "/usr/local/share/docker-init.sh" ]
# CMD [ "sleep", "infinity" ]

# # CMD /bin/sh -c "while sleep 1000; do :; done"