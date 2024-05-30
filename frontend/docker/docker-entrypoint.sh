#!/bin/sh
set -e

# Verifica se o package.json está presente
if [ ! -f /app/package.json ]; then
  echo "package.json not found, please make sure it's in the correct directory"
  exit 1
fi

# Instala as dependências
npm install

# Executa o comando fornecido (por exemplo, npm run serve)
exec "$@"
