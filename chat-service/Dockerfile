FROM python:3.11-slim

ARG TIMEZONE="Europe/Madrid"

ARG USER_ID=1000
ARG GROUP_ID=1000

# Arguments for the system user and group
ARG SYSTEM_USER="mario"
ARG SYSTEM_GROUP="mario"

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# Asigna grupo y usuario en contenedor para no tener que estar cambiando propietario a los archivos creados desde el contenedor
RUN groupadd --gid ${GROUP_ID} mario && \
	useradd --uid ${USER_ID} --gid ${GROUP_ID} -m mario && \
	usermod -aG www-data mario

WORKDIR /app

COPY requirements.txt .

RUN pip install --no-cache-dir -r requirements.txt

# Descargamos punkt durante el build para que ya esté dentro
RUN python -m nltk.downloader punkt punkt_tab

COPY . .

EXPOSE 5000

USER ${USER_ID}

CMD ["python", "app_chat.py"]
